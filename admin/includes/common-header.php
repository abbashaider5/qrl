<?php
// Professional admin header with modern theme
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Console | QLR</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: "Inter", system-ui, sans-serif; }
    :root { --sidebar-width: 260px; }
    .sidebar-icon { @apply w-5 h-5; }
  </style>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#EC8123',
            secondary: '#0C0A2E',
            accent: '#F6B530',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">