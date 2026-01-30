<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * 案件一覧ページを表示する
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(20);

        return view('projects.index', compact('projects'));
    }

    /**
     * 案件新規作成ページを表示する
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // 顧客名の選択肢
        $customers = Customer::all();

        // ステータスの選択肢
        $statuses = Project::STATUSES;

        // 担当者の選択肢
        $users = User::all();

        return view('projects.create', compact('customers', 'statuses', 'users'));
    }

    /**
     * 案件新規登録処理
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Project::create([
            'title' => $request->title,
            'customer_id' => $request->customer_id,
            'description' => $request->description,
            'status' => $request->status,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'assigned_user_id' => $request->assigned_user_id,
            'memo' => $request->memo,
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', '登録しました。');
    }

    /**
     * 案件詳細ページを表示する
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
