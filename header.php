<header class="head">
    
<a 
    href= "<?php echo "profil.php?id=".$_SESSION['id'];?>">
    <i class="fas fa-home"></i>
</a>



    <?php
    
        if(isset($_SESSION['id'])){
            if($_SESSION['id'] == $userInfo['id']){
        
            
        ?>
        <ul class="userInterface">
            <li><?php echo $userInfo['username']; ?></li>
            <li><a href="edit.php"><i class="fas fa-user-edit"></i></a></li>
            <li><a href="disconnect.php"><i class="fas fa-door-open"></i></a></li>
        </ul>
        
        <?php
            }else{
                ?>
                    <ul class="userInterface">
                        <li><a href="disconnect.php"><i class="fas fa-door-open"></i></a></li>
                    </ul>
                <?php

            }
        }
        ?>
</header>