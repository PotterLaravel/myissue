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

        <!-- Issue 详情 -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h3>Issue详情</h3>
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
                            <tr>
                                <td>{{ $issue->title }}</td>
                                    <td>{{ $issue->content }}</td>
                                    <td>{{ $issue->status }}</td>
                                    <td>{{ $issue->tags_name }}</td>
                                    <td>{{ $issue->created_at }}</td>
                                    <td>{{ $issue->updated_at }}</td>
                                    <td>{{ $issue->email }}</td>
                                <td>
                                    @if($issue->status == 'open' or $issue->status == 'reopen')
                                        <a href="/close_issue/{{$issue->id}}"" class="btn btn-warning">关闭</a>
                                    @else
                                        <a href="/reopen_issue/{{$issue->id}}"" class="btn btn-success">再次打开</a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h3>历史comment</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>内容</th>
                                <th>创建时间</th>
                                <th>创建人</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                                <tr>
                                    <td>{{ $comment->content }}</td>
                                    <td>{{ $comment->created_at }}</td>
                                    <td>{{ $comment->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h3>发布comment</h3>
                    <table class="table table-bordered">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="/store_comment" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                                    </div>
                                    <input type="hidden" name="issue_id" value="{{$issue->id}}">
                                    <br>
                                    <button type="submit" class="btn btn-success">提交</button>
                                </form>
                            </div>
                        </div>
                    </table>
            </div>
        </div>
    </div>


        
    <!-- 引入 Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
