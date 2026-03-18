<?php include('app/db.php') ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Careline Services (Bexley) Ltd</title>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=PT+Serif:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="shortcut icon" href="img/favicon.PNG" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: '#00AEEE',
                    brandDark: '#2589C9',
                    darkText: '#1f2937',
                    lightBg: '#f9fafb'
                },
                fontFamily: {
                    heading: ['"PT Serif"', 'serif'],
                    body: ['"PT Serif"', 'serif'],
                    // body: ['"DM Sans"', 'sans-serif'],
                }
            }
        }
    }
    </script>

    <link rel="stylesheet" href="style.css?v=<?= time(); ?>">
</head>