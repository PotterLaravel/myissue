<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Welcome, {{ session('userinfo')['loginname']}}</h2>
                <a href="/show_userinfo" class="btn btn-primary mb-3">编辑个人资料</a>
                <a href="/logout" class="btn btn-secondary mb-3"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    退出
                </a>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <!-- 发布 Issue 表单 -->
        <div class="row">
            <div class="col-md-6">
                <h3>新建Issue</h3>
                <form action="/store_issue" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">标题</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">内容</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                    <br>
                    标签 : 
                    @foreach ($tags as $v)
                        <input type="checkbox" name="tags[]" value="{{$v['id']}}" {{in_array($v['id'], ($posts['tags']??[]))?'checked':''}}> {{$v['name']}}

                    @endforeach
            
                    <br>
                    <button type="submit" class="btn btn-success">提交</button>
                </form>
            </div>
        </div>

        <!-- 历史 Issue 列表 -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h3>历史Issues</h3>
                <!-- 筛选表单 -->
        <form action="/issue_filter" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="tag" placeholder="输入标签...">
                <input type="text" class="form-control" name="title" placeholder="输入标题...">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">筛选</button>
                </div>
            </div>
        </form>
                @if ($issues->isEmpty())
                    <p>No issues found.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>标题</th>
                                <th>内容</th>
                                <th>状态</th>
                                <th>标签</th>
                                <th>创建时间</th>
                                <th>操作时间</th>
                                <th>创建人</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issues as $issue)
                                <tr>
                                    <td>{{ $issue->title }}</td>
                                    <td>{{ $issue->content }}</td>
                                    <td>{{ $issue->status }}</td>
                                    <td>{{ $issue->tags_name }}</td>
                                    <td>{{ $issue->created_at }}</td>
                                    <td>{{ $issue->updated_at }}</td>
                                    <td>{{ $issue->email }}</td>

                                    <td>
                                        <a href="/show_issue/{{$issue->id}}" class="btn btn-info">查看详情</a>
                                        @if($issue->status == 'open' or $issue->status == 'reopen')
                                            <a href="/close_issue/{{$issue->id}}"" class="btn btn-warning">关闭</a>
                                        @else
                                            <a href="/reopen_issue/{{$issue->id}}"" class="btn btn-success">再次打开</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                    {{$issues->links()}}
                @endif
                
            </div>
        </div>
    </div>

    <!-- 引入 Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script>
        Echo.channel("messages")
            .listen("messages", (e)=>{
                console.log(e);
            });
    </script> --}}
</body>
</html>
