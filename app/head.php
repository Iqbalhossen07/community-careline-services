<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($pageTitle) ? $pageTitle : 'Home'; ?> - Careline</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=PT+Serif:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<link rel="stylesheet" href="style.css?v=<?= time(); ?>">
<link rel="shortcut icon" href="../img/favicon.PNG" type="image/x-icon">

<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'primary-start': '#00AEEE', // আপনার দেওয়া কালার
                'primary-end': '#2589C9',
                'sidebar-bg': '#ffffff',
            },
            fontFamily: {
                // হেডিং, বডি এবং নেভিগেশনের জন্য নির্দিষ্ট ফন্টসমূহ
                'heading': ['"PT Serif"', 'serif'],
                'body': ['"PT Serif"', 'serif'],
                'nav': ['"PT Serif"', 'serif'],
            }
        }
    }
}
</script>