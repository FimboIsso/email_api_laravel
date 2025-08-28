<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .email-content {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .extra-data {
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 15px;
        }

        .error-message {
            background: #ffe6e6;
            color: #d00;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 15px;
        }

        .data-item {
            margin: 5px 0;
        }

        .data-label {
            font-weight: bold;
            display: inline-block;
            min-width: 100px;
        }
    </style>
</head>

<body>
    @if (isset($error))
        <div class="error-message">
            <strong>Erreur de template:</strong> {{ $error }}
        </div>
    @endif

    <div class="email-content">
        {!! nl2br(e($content)) !!}
    </div>

    @if (!empty($data) && is_array($data))
        <div class="extra-data">
            <h3>Données supplémentaires:</h3>
            @foreach ($data as $key => $value)
                <div class="data-item">
                    <span class="data-label">{{ $key }}:</span>
                    @if (is_array($value))
                        {{ json_encode($value) }}
                    @else
                        {{ $value }}
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</body>

</html>
