<?php
function renderPageFoot() {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/Config/config.ini");
    $pageRoot = $config['page_root'];
    return <<<HTML
        
            </div>
        </main>
        <footer class="page-footer">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">
                    <img src="https://bayview.club/wp-content/uploads/2019/04/bsscc-transparent-background-pink-logo-white-text-768x432.png" height="100vh" /> 
                </h5>
                <p class="grey-text text-lighten-4">
                BayviewJudge was created by the Bayview Computer Club. <br />
                It is free (as in freedom) software licenced under the GNU AGPL v3.
                </p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Source</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="https://github.com/BayviewComputerClub/BayviewJudge-UI">Web UI</a></li>
                  <li><a class="grey-text text-lighten-3" href="https://github.com/BayviewComputerClub/BayviewJudge-Grader">Grader Server</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2019 Seshan Ravikumar. 
            <a class="grey-text text-lighten-4 right" href="https://bayview.club">Club Website</a>
            </div>
          </div>
        </footer>
        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="$pageRoot/Assets/materialize/js/materialize.min.js"></script>
    </body>
</html>
HTML;

}