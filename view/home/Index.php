
    <h2>Home</h2>
    <p>w00t!</p>
    <ul>
      <?php
            foreach ($view['links'] as $key => $value) {
              echo '<li><a href="' .$value['path']. '">' .$value['text'].'</a>';
            }

            d($view);
