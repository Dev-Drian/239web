<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Assigned</title>
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
        
        .task-card {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 4px solid #4f46e5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .task-header {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .task-title {
            font-weight: 600;
            color: #111827;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .task-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #4b5563;
        }
        
        .meta-item strong {
            margin-right: 5px;
            color: #111827;
        }
        
        .priority {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            text-transform: capitalize;
        }
        
        .priority-high {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        
        .priority-medium {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .priority-low {
            background-color: #ecfdf5;
            color: #065f46;
        }
        
        .task-description {
            color: #4b5563;
            line-height: 1.7;
            font-size: 15px;
            margin-top: 15px;
        }
        
        .task-description p {
            margin: 0 0 15px 0;
        }
        
        .assigner-info {
            margin: 25px 0;
            color: #4b5563;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .assigner-info strong {
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
            
            .task-card {
                padding: 20px;
            }
            
            .task-meta {
                flex-direction: column;
                gap: 8px;
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
            <h1>New Task Assigned to You</h1>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">Hello,</div>
            
            <div class="task-card">
                <div class="task-header">
                    <div class="task-title">{{ $task->name }}</div>
                    <div class="task-meta">
                        <div class="meta-item">
                            <strong>Priority:</strong>
                            <span class="priority priority-{{ $task->priority }}">{{ $task->priority }}</span>
                        </div>
                        <div class="meta-item">
                            <strong>Due Date:</strong>
                            {{ $task->due_date ? $task->due_date->format('M d, Y') : 'Not set' }}
                        </div>
                        <div class="meta-item">
                            <strong>Board:</strong>
                            {{ $this->board->name }}
                        </div>
                    </div>
                </div>
                
                <div class="task-description">
                    <p>{{ $task->description ?? 'No description provided' }}</p>
                </div>
            </div>
            
            <div class="assigner-info">
                <p>This task was assigned to you by <strong>{{ Auth::user()->name }}</strong>.</p>
            </div>
            
            <div class="button-container">
                <a href="{{ url('/tasks/' . $task->id) }}" class="cta-button">View Task</a>
            </div>
            
            <p style="text-align: center; color: #6b7280; font-size: 14px;">
                Can't click the button? Copy and paste this link into your browser:<br>
                <span style="word-break: break-all; color: #4f46e5;">{{ url('/tasks/' . $task->id) }}</span>
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