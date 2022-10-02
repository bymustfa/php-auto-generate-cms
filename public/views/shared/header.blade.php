<!DOCTYPE html>
<html class="scroll-smooth overflow-x-hidden" lang="en">
<head>
    <meta charset="utf-8">
    <base href="{{base_url()}}" />
    <title>CMS | @yield('title', "")</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <link rel="icon" href="{{assets("images/icons/icon-favicon.svg")}}" type="image/x-icon" sizes="16x16">
    <link rel="stylesheet" href="{{assets("styles/tailwind.min-v=2.0.css")}}">
    <link rel="stylesheet" href="{{assets("styles/style.min-v=2.0.css")}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Chivo:wght@400;700;900&family=Noto+Sans:wght@400;500;600;700;800&display=swap">
</head>
<body class="w-screen relative overflow-x-hidden min-h-screen bg-gray-100 ecommerce-dashboard-page dark:bg-[#000]">
