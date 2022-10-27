
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Swagger UI</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url('App/Routes/Doc/swagger-ui.css')?>" />
    <link rel="stylesheet" type="text/css" href="<?=base_url('App/Routes/Doc/index.css')?>" />
    <link rel="icon" type="image/png" href="<?=base_url('App/Routes/Doc/favicon-32x32.png')?>" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?=base_url('App/Routes/Doc/favicon-16x16.png')?>" sizes="16x16" />
  </head>

  <body data-apiUrl="<?=base_url('doc/generate.json')?>">
    <div id="swagger-ui"></div>
    <script src="<?=base_url('App/Routes/Doc/swagger-ui-bundle.js')?>" charset="UTF-8"> </script>
    <script src="<?=base_url('App/Routes/Doc/swagger-ui-standalone-preset.js')?>" charset="UTF-8"> </script>
    <script src="<?=base_url('App/Routes/Doc/swagger-initializer.js')?>" charset="UTF-8"> </script>
  </body>
</html>
