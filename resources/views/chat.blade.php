<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat con GPT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-container {
            height: 500px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .user-message {
            background-color: #e3f2fd;
            margin-left: 20%;
        }
        .bot-message {
            background-color: #f5f5f5;
            margin-right: 20%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center mb-4">Chat con GPT</h2>
                <div class="chat-container" id="chatContainer">
                    <!-- Los mensajes se agregarán aquí -->
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="userInput" placeholder="Escribe tu mensaje...">
                    <button class="btn btn-primary" id="sendButton">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sendButton').click(function() {
                sendMessage();
            });

            $('#userInput').keypress(function(e) {
                if (e.which == 13) {
                    sendMessage();
                }
            });

            function sendMessage() {
                const userInput = $('#userInput').val().trim();
                if (userInput === '') return;

                // Agregar mensaje del usuario al chat
                appendMessage(userInput, 'user');
                $('#userInput').val('');

                // Enviar mensaje al servidor
                $.ajax({
                    url: '/chat/send',
                    method: 'POST',
                    data: {
                        message: userInput,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        appendMessage(response, 'bot');
                    },
                    error: function(xhr, status, error) {
                        appendMessage('Error al procesar la solicitud', 'bot');
                    }
                });
            }

            function appendMessage(message, type) {
                const messageClass = type === 'user' ? 'user-message' : 'bot-message';
                const messageHtml = `<div class="message ${messageClass}">${message}</div>`;
                $('#chatContainer').append(messageHtml);
                $('#chatContainer').scrollTop($('#chatContainer')[0].scrollHeight);
            }
        });
    </script>
</body>
</html>
