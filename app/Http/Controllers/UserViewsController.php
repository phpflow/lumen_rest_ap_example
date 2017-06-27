<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Jenkinsmgmt\Helpers\Helper;
use Validator;
use App\Models\UserViews;
use App\Models\UserViewDetails;

class UserViewsController extends Controller {
public function getAllUserViews(Request $request) {
      $user_views  = UserViews::with('UserViewDetails')->get();
      if(!empty($user_views)) {
         return response()->json($user_views);
         
      }
   }
   /**
    * Method to get View by id
    *
    * @author parvez.alam
    */
   public function getUserViewById(Request $request, $id) {
      
      $rules =  array(
            'id'    => 'required'
        );
        
        $messages = array(
            'id.required' => 'id is required.'
        );
      
      $validator = \Validator::make(array('id' => $id), $rules, $messages);

      if(!$validator->fails()) {

         $user_views  = UserViews::with('UserViewDetails')->where('id', $id)->get();//

        return response()->json($user_views);
      } else {
            $errors = $validator->errors();
            return response()->json($errors->all());
      }
   }
   
   /**
    * Method to save user View
    *
    * @author parvez.alam
    */
   public function createUserView(Request $request) {
      $response = array();
      $parameters = $request->json()->all();
      
      $rules =  array(
            'name'    => 'required'
        );
        
        $messages = array(
            'name.required' => 'view name is required.',
            'updated_by.required' => 'user name is required.'
        );
      
      $validator = \Validator::make(array('name' => $parameters['name']), $rules, $messages);

      if(!$validator->fails()) {
            
            $createdView = UserViews::create(array('name'=>$parameters['name'], 'created_by'=>$parameters['created_by'], 'updated_by'=>$parameters['updated_by']));

            if(!empty($createdView->id) && !empty($parameters['views'])) {

               foreach($parameters['views'] as $k =>$v) {
                  $viewDetails = array();
                  $viewDetails['view_id'] = $createdView->id;
                  $viewDetails['service_name'] = $v;                  
                  $details = UserViewDetails::create($viewDetails);
                }
            }
            return response()->json(createdView);
         } else {
            $errors = $validator->errors();
            return response()->json($errors->all());
         }
      
   }
   
   /**
    * Method to save user View
    *
    * @author parvez.alam
    */
   public function saveUserView(Request $request) {
      $response = array();
      $parameters = $request->json()->all();
      
      $rules =  array(
            'name'    => 'required'
        );
        
        $messages = array(
            'name.required' => 'view name is required.'
        );
      //return $parameters;
      $validator = \Validator::make(array('name' => $parameters['name']), $rules, $messages);

      if(!$validator->fails()) {
            //return Helper::jsonpSuccess($parameters);
            $view = UserViews::find($parameters['id']);
            $view->name = $parameters['name'];
            $view->updated_by = $parameters['updated_by'];

            $saveView = $view->save();
            
            if(!empty($parameters['id']) && $saveView) {
                
               foreach($parameters['views'] as $k =>$v) {
                  
                  if($v['id'] > 0) {
                     if($v['status'] < 0) {
                        $viewDetails = UserViewDetails::find($v['id']);

                        $details = $viewDetails->delete();
                     }
                     //return Helper::jsonpSuccess($details); 
                  } else {
                     $viewDetails = array();
                     $viewDetails['view_id'] = $parameters['id'];
                     $viewDetails['service_name'] = $v['name'];
                     $viewDetails['updated_by'] = $parameters['updated_by'];                
                     $details = UserViewDetails::create($viewDetails);
                  }
                }
            }
            return response()->json($saveView);
         } else {
            $errors = $validator->errors();
            return response()->json($errors->all());
         }
      
   }
   
   /**
    * Method to delete user View
    *
    * @author parvez.alam
    */
   public function deleteUserView($id) {
      $response = array();

      if(!empty($id)) {
            $view = UserViews::find($id);
            $response = $view->UserViewDetails()->delete();
            $response = $view->delete();

            return response()->json($response);
         } else {
            
            return response()->json('Id is not defined!');
         }
      
   }
}