<?php  
    class dbConnect {  
        function __construct() {  
            
        }  
        public function Close(){  
            mysqli_close($conn);  
        }  
    }  
?>  