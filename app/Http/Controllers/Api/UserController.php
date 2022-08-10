<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    public function list($config = null)
    {
        $whereLike = ['email','name'];
        $user = User::select('*');
        if ($config) {
            $config = json_decode(base64_decode($config), true);
        }else{
            $config = [
                'email' => '',
                'name' => '',
                'paginate' => '10',
                'page' => '1',
                'pageLast' => '1',
                'orderBy' => ['key'=>'name', 'value'=>'ASC']
            ];
        }
        foreach ($whereLike as $key) { if (!empty($config[$key])) { $user->where($key,'LIKE','%'.$config[$key].'%'); } }
        $user = $user->orderBy(
            $config['orderBy']['key'],$config['orderBy']['value']
        )->paginate($config['paginate'], ['*'], 'page', $config['page']);
        return response()->json([
            'res' => true,
            'result' => [
                'data' => $user,
                'config' => $config,
            ]
        ]);
    }

    public function open(Request $request, $id)
    {
        return response()->json([
            'res' => true,
            'result' => [
                'data' => User::find($id)
            ]
        ]);
    }

    public function create(Request $request)
    {
        $input = [
            'name' => $request->data['name'],
            'password' => $request->data['password'],
            'email' => $request->data['email'],
        ];
        $message = [];
        $rule_validate = [
            'name' => 'required|max:175',
            'password' => 'required|max:175',
            'email' => 'required|max:175|unique:users,email',
        ];
        $validator = Validator::make($input, $rule_validate, $message);
        if ($validator->fails()) {
            $err = [];
            $validator = $validator->getMessageBag()->toArray();
            foreach ($validator as $key => $arr) { $err[] = $key." : ".$arr[0]; }
            return response()->json([
                'res' => false,
                'err' => $err
            ]);
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);

        return response()->json([
            'res' => true,
            'result' => [
                'User' => User::find($user->id)
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $input = [
            'name' => $request->data['name'],
            'email' => $request->data['email'],
        ];
        $message = [];
        $rule_validate = [
            'name' => 'required|max:175',
            'email' => 'required|max:175|unique:users,email,'.$id,
        ];
        $validator = Validator::make($input, $rule_validate, $message);
        if ($validator->fails()) {
            $err = [];
            $validator = $validator->getMessageBag()->toArray();
            foreach ($validator as $key => $arr) { $err[] = $key." : ".$arr[0]; }
            return response()->json([
                'res' => false,
                'err' => $err
            ]);
        }

        $user = User::where('id',$id)->update([
            'name' => $input['name'],
            'email' => $input['email'],
        ]);

        return response()->json([
            'res' => true,
            'result' => [
                'User' => User::find($id)
            ]
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'res' => false,
                'err' => [
                    'Sorry user not found...!'
                ]
            ]);
        }
        $user->delete();
        return response()->json([
            'res' => true,
            'result' => [
                'msg' => 'success delete user'
            ]
        ]);
    }
}
