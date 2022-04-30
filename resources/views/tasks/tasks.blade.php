@if (count($tasks) > 0)
    <h1>タスク一覧</h1>
    <table class="table table-striped">
        <thread>
            <tr>
                <th>id</th>
                <th>ステータス</th>
                <th>タスク</th>
            </tr>
        </thread>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->content }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
  
    
    {{ $tasks->links() }}
    
    
@endif
    