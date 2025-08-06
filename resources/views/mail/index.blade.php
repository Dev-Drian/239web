<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Chat Message Notification</title>
    <style>
        /* Base styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f5f7fa;
        }
        
        /* Main container */
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        /* Header section */
        .header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            padding: 30px;
            text-align: center;
            color: white;
        }
        
        .logo {
            height: 48px;
            margin-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        /* Content section */
        .content {
            padding: 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #374151;
            margin-bottom: 25px;
            font-weight: 500;
        }
        
        .message-card {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 4px solid #4f46e5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .subject {
            font-weight: 600;
            color: #111827;
            font-size: 18px;
        }
        
        .date {
            color: #6b7280;
            font-size: 14px;
        }
        
        .message-body {
            color: #4b5563;
            line-height: 1.7;
            font-size: 15px;
        }
        
        .message-body p {
            margin: 0 0 15px 0;
        }
        
        .sender-info {
            margin: 25px 0;
            color: #4b5563;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .sender-info strong {
            color: #111827;
        }
        
        .button-container {
            text-align: center;
            margin: 30px 0 20px;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(79, 70, 229, 0.3);
        }
        
        /* Footer section */
        .footer {
            background-color: #f9fafb;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }
        
        .social-links a:hover {
            color: #4f46e5;
        }
        
        .disclaimer {
            margin-top: 20px;
            font-size: 12px;
            color: #9ca3af;
            line-height: 1.5;
        }
        
        /* Responsive adjustments */
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
                box-shadow: none;
            }
            
            .header, .content, .footer {
                padding: 25px 20px;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .message-card {
                padding: 20px;
            }
            
            .message-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .date {
                margin-top: 8px;
                align-self: flex-end;
            }
            
            .cta-button {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('img/logo.png') }}" alt="Company Logo" class="logo">
            <h1>New Message in Your Chat</h1>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">Hello,</div>
            
            <div class="message-card">
                <div class="message-header">
                    <div class="subject">{{ $asunto ?? 'New chat message' }}</div>
                    <div class="date">{{ $date }}</div>
                </div>
                
                <div class="message-body">
                    <p>{{ $message_content }}</p>
                </div>
            </div>
            
            <div class="sender-info">
                <p>This message was sent by <strong>{{ $from_user }}</strong> in the chat: <strong>{{ $chat }}</strong>.</p>
            </div>
            
            <div class="button-container">
                <a href="{{ route('chat.index') }}" class="cta-button">Reply in Chat</a>
            </div>
            
            <p style="text-align: center; color: #6b7280; font-size: 14px;">
                Can't click the button? Copy and paste this link into your browser:<br>
                <span style="word-break: break-all; color: #4f46e5;">{{ route('chat.index') }}</span>
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="social-links">
                <a href="https://facebook.com/yourcompany">Facebook</a>
                <a href="https://twitter.com/yourcompany">Twitter</a>
                <a href="https://linkedin.com/company/yourcompany">LinkedIn</a>
            </div>
            
            <p class="disclaimer">
                This is an automated notification. Please do not reply to this email directly.<br>
                © {{ date('Y') }} Your Company Name. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>