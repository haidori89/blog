<?php

class vals{     //get old vals that submited from forms
    protected  $old_val;

            function set_vals($post_var)
            {
                if(isset($_POST[$post_var])){
                $this->old_val =htmlentities(htmlspecialchars(trim($_POST[$post_var])));
                return $this->old_val;
                }
 
}
}

?>