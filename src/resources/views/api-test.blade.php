<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API テスト - データ取得</title>
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
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
        .btn-primary:disabled {
            background: #a0aec0;
            cursor: not-allowed;
        }
        .btn-secondary {
            background: #cbd5e0;
            color: #2d3748;
            margin-left: 10px;
        }
        .btn-secondary:hover {
            background: #a0aec0;
        }
        .button-group {
            display: flex;
            gap: 10px;
        }
        .response-area {
            background: #f7fafc;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
            min-height: 150px;
            max-height: 400px;
            overflow-y: auto;
        }
        .response-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #2d3748;
        }
        .status-code {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .status-200 {
            background: #48bb78;
            color: white;
        }
        .status-error {
            background: #f56565;
            color: white;
        }
        pre {
            background: #2d3748;
            color: #48bb78;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin-top: 10px;
        }
        .todo-list {
            margin-top: 20px;
        }
        .todo-item {
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            margin-bottom: 10px;
            background: white;
        }
        .todo-title {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
        }
        .todo-description {
            font-size: 14px;
            color: #718096;
            margin-bottom: 5px;
        }
        .todo-meta {
            font-size: 12px;
            color: #a0aec0;
        }
        .todo-completed {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
        .completed-true {
            background: #48bb78;
            color: white;
        }
        .completed-false {
            background: #cbd5e0;
            color: #2d3748;
        }
        .loading {
            color: #667eea;
            font-style: italic;
        }
        .error {
            color: #f56565;
            font-weight: bold;
        }
        .info-box {
            background: #edf2f7;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 20px;
        }
        .info-box h3 {
            margin-bottom: 10px;
            color: #2d3748;
        }
        .info-box p {
            color: #4a5568;
            margin-bottom: 5px;
        }
        .link {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }
        .link:hover {
            text-decoration: underline;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #2d3748;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }
        .divider {
            height: 2px;
            background: linear-gradient(to right, #667eea, #764ba2);
            margin: 30px 0;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔌 API テスト - データ取得</h1>

        <div class="card">
            <div class="info-box">
                <h3>このページについて</h3>
                <p>JavaScriptのFetch APIを使って、LaravelのAPIエンドポイントとの通信を学習するページです。</p>
                <p>実装エンドポイント: <code>GET /api/todos</code>, <code>POST /api/todos</code></p>
            </div>

            <div class="section-title">📝 Todoを作成 (POST)</div>
            <div class="form-group">
                <label for="todoTitle">タイトル *</label>
                <input type="text" id="todoTitle" placeholder="Todoのタイトルを入力...">
            </div>
            <div class="form-group">
                <label for="todoDescription">説明（任意）</label>
                <textarea id="todoDescription" placeholder="説明を入力..."></textarea>
            </div>
            <button id="createBtn" class="btn btn-primary">Todoを作成 (POST)</button>

            <div class="divider"></div>

            <div class="section-title">📋 データ取得 (GET)</div>
            <div class="button-group">
                <button id="fetchBtn" class="btn btn-primary">データを取得 (GET)</button>
                <button id="clearBtn" class="btn btn-secondary">画面をクリア</button>
            </div>

            <div class="response-area">
                <div class="response-title">レスポンス:</div>
                <div id="responseStatus"></div>
                <div id="responseContent">ボタンをクリックしてデータを取得してください。</div>
            </div>

            <div id="todoListArea"></div>
        </div>
    </div>

    <script>
        const fetchBtn = document.getElementById('fetchBtn');
        const clearBtn = document.getElementById('clearBtn');
        const createBtn = document.getElementById('createBtn');
        const todoTitle = document.getElementById('todoTitle');
        const todoDescription = document.getElementById('todoDescription');
        const responseStatus = document.getElementById('responseStatus');
        const responseContent = document.getElementById('responseContent');
        const todoListArea = document.getElementById('todoListArea');

        fetchBtn.addEventListener('click', async () => {
            fetchBtn.disabled = true;
            responseContent.innerHTML = '<p class="loading">データを取得中...</p>';
            responseStatus.innerHTML = '';
            todoListArea.innerHTML = '';

            try {
                const response = await fetch('/api/todos', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                const statusClass = response.ok ? 'status-200' : 'status-error';
                responseStatus.innerHTML = `<span class="${statusClass}">HTTPステータス: ${response.status} ${response.statusText}</span>`;

                const data = await response.json();

                responseContent.innerHTML = `
                    <pre>${JSON.stringify(data, null, 2)}</pre>
                `;

                if (data.success && data.data && data.data.length > 0) {
                    renderTodoList(data.data);
                } else if (data.success && data.data && data.data.length === 0) {
                    todoListArea.innerHTML = `
                        <div class="response-area" style="margin-top: 20px;">
                            <p style="text-align: center; color: #a0aec0;">Todoがありません。<a href="{{ route('todos.index') }}" class="link">Todoリスト画面</a>から追加してください。</p>
                        </div>
                    `;
                }

            } catch (error) {
                responseStatus.innerHTML = '<span class="status-error">エラー</span>';
                responseContent.innerHTML = `<p class="error">エラーが発生しました: ${error.message}</p>`;
            } finally {
                fetchBtn.disabled = false;
            }
        });

        clearBtn.addEventListener('click', () => {
            responseStatus.innerHTML = '';
            responseContent.innerHTML = 'ボタンをクリックしてデータを取得してください。';
            todoListArea.innerHTML = '';
        });

        createBtn.addEventListener('click', async () => {
            const title = todoTitle.value.trim();
            const description = todoDescription.value.trim();

            if (!title) {
                alert('タイトルを入力してください');
                return;
            }

            createBtn.disabled = true;
            responseContent.innerHTML = '<p class="loading">Todoを作成中...</p>';
            responseStatus.innerHTML = '';
            todoListArea.innerHTML = '';

            try {
                const response = await fetch('/api/todos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        title: title,
                        description: description || null,
                    })
                });

                const statusClass = response.ok ? 'status-200' : 'status-error';
                responseStatus.innerHTML = `<span class="${statusClass}">HTTPステータス: ${response.status} ${response.statusText}</span>`;

                const data = await response.json();

                responseContent.innerHTML = `
                    <pre>${JSON.stringify(data, null, 2)}</pre>
                `;

                if (data.success) {
                    todoTitle.value = '';
                    todoDescription.value = '';
                    alert('Todoを作成しました！「データを取得」ボタンで確認できます。');
                }

            } catch (error) {
                responseStatus.innerHTML = '<span class="status-error">エラー</span>';
                responseContent.innerHTML = `<p class="error">エラーが発生しました: ${error.message}</p>`;
            } finally {
                createBtn.disabled = false;
            }
        });

        function renderTodoList(todos) {
            const html = `
                <div class="todo-list">
                    <h3 style="margin-bottom: 15px; color: #2d3748;">取得したTodo一覧 (${todos.length}件)</h3>
                    ${todos.map(todo => `
                        <div class="todo-item">
                            <div class="todo-title">
                                ${escapeHtml(todo.title)}
                                <span class="todo-completed ${todo.completed ? 'completed-true' : 'completed-false'}">
                                    ${todo.completed ? '完了' : '未完了'}
                                </span>
                            </div>
                            ${todo.description ? `<div class="todo-description">${escapeHtml(todo.description)}</div>` : ''}
                            <div class="todo-meta">
                                ID: ${todo.id} | 作成日時: ${formatDate(todo.created_at)}
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
            todoListArea.innerHTML = html;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleString('ja-JP');
        }
    </script>
</body>
</html>
