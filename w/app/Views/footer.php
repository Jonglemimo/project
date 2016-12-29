<footer class="footer footer-padding">

    <div class="footer-copyright">
        <p>© Tutomotion 2016</p>
    </div>

    <div class="footer-links">
        <a href="#">Conditions d'utilisation</a>
         -
        <a href="#">Confidentialité</a>
         -
        <a href="#">Foire aux questions</a>
         -
        <a href="#">Nous contacter</a>
    </div>

</footer>

<script>
var currentUrl = '<?= $this->url('default_home')?>';
</script>
<!-- JQUERY 3.1.1 -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<!-- BOOTSTRAP CDN 3.3.7 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="//vjs.zencdn.net/5.11/video.min.js"></script>
<!-- CUSTOM JS -->
<script src="<?= $this->assetUrl('js/script.js') ?>"></script>
<?= $this->section('script') ?>
</body>
</html>