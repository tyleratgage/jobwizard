<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return to Work Offer Letter</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            padding: 0.5in;
        }
        p {
            margin-bottom: 1em;
        }
        ul {
            margin-left: 1.5em;
            margin-bottom: 1em;
        }
        li {
            margin-bottom: 0.5em;
        }
        .offer-letter-header-info {
            font-size: 10pt;
            margin-bottom: 1em;
        }
        .page-break-after {
            page-break-after: always;
        }
        .cc-list {
            list-style: none;
            margin-left: 0;
        }
        strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    @include('offer-letter.templates.' . $templateName, $data)
</body>
</html>
