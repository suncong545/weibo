<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'content' => 'required|max:140'
    	]);

    	Auth::user()->statuses()->create([
    		'content' => $request['content']
    	]);
    	session()->flash('success', '发布时间');
    	return redirect()->back();
    }

    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status); //做删除授权的检测，不通过会抛出 403 异常。
        $status->delete(); //调用 Eloquent 模型的 delete 方法对该微博进行删除。
        session()->flash('success', '微博已被成功删除！'); //删除成功之后，将返回到执行删除微博操作的页面上。
        return redirect()->back();
    }
}
