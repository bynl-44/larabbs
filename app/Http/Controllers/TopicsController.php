<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\View\View;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * @param Request $request
     * @param Topic $topic
     * @return Factory|View
     */
    public function index(Request $request, Topic $topic)
    {
        $topics = $topic->withOrder($request->order)->paginate(20);

        return view('topics.index', compact('topics'));
    }

    /**
     * @param Topic $topic
     * @return Factory|View
     */
    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    /**
     * @param Topic $topic
     * @return Factory|View
     */
    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * @param TopicRequest $request
     * @param Topic $topic
     * @return RedirectResponse
     */
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = \Auth::id();
        $topic->save();

        return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功！');
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic','categories'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->route('topics.show', $topic)->with('success', '更新成功！');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploadHandler)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success' => false,
            'msg' => '上传失败',
            'file_path' => '',
        ];

        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file)
        {
            // 保存图片到本地
            $result = $uploadHandler->save($request->upload_file,'topics',\Auth::id(),1024);

            // 图片保存成功的话
            if ($result)
            {
                $data['success'] = true;
                $data['msg'] = '上传成功';
                $data['file_path'] = $result['path'];
            }
        }

        return $data;
    }
}
