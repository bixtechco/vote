<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        .header h1 {
            font-size: 24px;
            color: #333333;
        }
        .content {
            padding: 20px 0;
        }
        .content p {
            font-size: 16px;
            color: #666666;
            line-height: 1.5;
        }
        .content a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 14px;
            color: #aaaaaa;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #008CBA;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <h1>Voting Session Closed</h1>
    </div>
    <div class="content">
        <p>Hello,</p>
        <p>The voting session "<strong>{{ $votingSession->name }}</strong>" has ended. Thank you for your participation.</p>
        <p>You can view the results of the voting session by clicking the button below:</p>
        <p><a href="{{ url('/voting/associations/'. $association->id . '/voting-sessions/'. $votingSession->id) }}" class="button">View Results</a></p>
        <p>Best regards,</p>
        <p>Your Team</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Voting App. All rights reserved.
    </div>
</div>
</body>
</html>
