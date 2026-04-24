<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ mới - Viam Semicon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .wrapper {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #003087;
            color: #ffffff;
            padding: 24px 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        .body {
            padding: 30px;
        }
        .field {
            margin-bottom: 18px;
        }
        .field-label {
            font-weight: bold;
            font-size: 13px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 4px;
        }
        .field-value {
            font-size: 15px;
            color: #222;
            word-break: break-word;
        }
        .message-box {
            background: #f9f9f9;
            border-left: 4px solid #003087;
            padding: 14px 18px;
            border-radius: 4px;
            font-size: 15px;
            line-height: 1.6;
            color: #333;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #f0f0f0;
            padding: 14px 30px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Liên hệ mới từ website Viam Semicon</h1>
        </div>

        <div class="body">
            <div class="field">
                <div class="field-label">Họ tên</div>
                <div class="field-value">{{ $contact->name }}</div>
            </div>

            @if ($contact->email)
            <div class="field">
                <div class="field-label">Email</div>
                <div class="field-value">
                    <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                </div>
            </div>
            @endif

            @if ($contact->phone)
            <div class="field">
                <div class="field-label">Số điện thoại</div>
                <div class="field-value">{{ $contact->phone }}</div>
            </div>
            @endif

            @if ($contact->subject)
            <div class="field">
                <div class="field-label">Chủ đề</div>
                <div class="field-value">{{ $contact->subject }}</div>
            </div>
            @endif

            <div class="field">
                <div class="field-label">Nội dung</div>
                <div class="message-box">{{ $contact->message }}</div>
            </div>

            <div class="field">
                <div class="field-label">Thời gian gửi</div>
                <div class="field-value">{{ $contact->created_at->format('H:i:s d/m/Y') }}</div>
            </div>
        </div>

        <div class="footer">
            Email này được gửi tự động từ hệ thống website <strong>Viam Semicon</strong>.
            Vui lòng không trả lời email này trực tiếp nếu không có yêu cầu.
        </div>
    </div>
</body>
</html>
