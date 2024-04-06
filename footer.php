<?php 
include_once 'config.php';
include_once 'ad.php';?>

<!-- footer - start -->
<div class="bg-gray-900">
  <footer class="max-w-screen-2xl px-4 md:px-8 mx-auto">
    <div class="text-gray-400 text-sm text-center border-t border-gray-800 py-8">© 2022 - <?php echo $Name;?>. All rights reserved.</div>
  </footer>
</div>
<!-- footer - end -->
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $gtag;?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo $Name;?>');
</script>

</body>
</html>