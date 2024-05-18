<!DOCTYPE html>
<html>
<head>
    <title>Voting Session Closed</title>
</head>
<body>
    <h1>Voting Session Closed</h1>

    <p>Hello,</p>

    <p>The voting session "{{ $votingSession->name }}" has ended. Thank you for your participation.</p>

    <p>You can view the results of the voting session by clicking the button below:</p>

    <a href="{{ url('/voting/associations/'. $association->id . '/voting-sessions/'. $votingSession->id) }}" style="background-color: #008CBA; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border: none;">View Results</a>

    <p>Best regards,</p>

    <p>Your Team</p>
</body>
</html>
