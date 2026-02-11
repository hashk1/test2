<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todoリスト</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
        }
        .add-form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            font-family: inherit;
        }
        input[type="text"]:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
        }
        .btn-toggle {
            background: #48bb78;
            color: white;
            padding: 8px 16px;
            font-size: 14px;
        }
        .btn-toggle:hover {
            background: #38a169;
        }
        .btn-delete {
            background: #f56565;
            color: white;
            padding: 8px 16px;
            font-size: 14px;
        }
        .btn-delete:hover {
            background: #e53e3e;
        }
        .todo-list {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .todo-item {
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.3s;
        }
        .todo-item:hover {
            background: #f7fafc;
        }
        .todo-item:last-child {
            border-bottom: none;
        }
        .todo-content {
            flex: 1;
            margin-right: 10px;
        }
        .todo-title {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
        }
        .todo-title.completed {
            text-decoration: line-through;
            color: #a0aec0;
        }
        .todo-description {
            font-size: 14px;
            color: #718096;
            line-height: 1.5;
        }
        .todo-description.completed {
            color: #cbd5e0;
        }
        .todo-actions {
            display: flex;
            gap: 10px;
        }
        .empty-state {
            padding: 40px;
            text-align: center;
            color: #a0aec0;
            font-size: 18px;
        }
        .success-message {
            background: #48bb78;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .error-message {
            background: #f56565;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Todoリスト</h1>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-message">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="add-form">
            <form action="{{ route('todos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="title" placeholder="Todoのタイトル..." required>
                    <textarea name="description" placeholder="説明（任意）"></textarea>
                    <button type="submit" class="btn btn-primary">追加</button>
                </div>
            </form>
        </div>

        <div class="todo-list">
            @forelse($todos as $todo)
                <div class="todo-item">
                    <div class="todo-content">
                        <div class="todo-title {{ $todo->completed ? 'completed' : '' }}">
                            {{ $todo->title }}
                        </div>
                        @if($todo->description)
                            <div class="todo-description {{ $todo->completed ? 'completed' : '' }}">
                                {{ $todo->description }}
                            </div>
                        @endif
                    </div>
                    <div class="todo-actions">
                        <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-toggle">
                                {{ $todo->completed ? '未完了に戻す' : '完了' }}
                            </button>
                        </form>
                        <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="return confirm('本当に削除しますか？')">
                                削除
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    まだTodoがありません。上のフォームから追加してください。
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>
