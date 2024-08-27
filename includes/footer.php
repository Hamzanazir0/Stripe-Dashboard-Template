<footer class="pt-4 my-md-5 pt-md-5  footer mt-auto">
    <div class="container border-top">
        <div class="row">
            <div class="col-4 col-md">
                <h5>About</h5>
                <ul class="list-unstyled text-small">
                    <li class="mb-1"><a class="link-secondary text-decoration-none" href="index">Home</a></li>
                    <li class="mb-1"><a class="link-secondary text-decoration-none" href="terms">Terms</a></li>
                    <li class="mb-1"><a class="link-secondary text-decoration-none" href="privacy">Privacy</a></li>
                    <li class="mb-1"><a class="link-secondary text-decoration-none" href="contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php
    $html = ob_get_clean();
    $html = preg_replace('/<!--(.|\s)*?-->/', '', $html); // Remove HTML comments
    $html = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $html); // Remove CSS comments
    echo $html;
?>
