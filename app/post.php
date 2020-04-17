<?php
require_once('config.php');
header("Access-Control-Allow-Origin: *");




     $postId=$_POST['postId'];
   
          $sql="SELECT * from posts WHERE id=$postId ";
          $result=$conn-> query($sql);
          if($result->num_rows>0)
          {
              $row=$result->fetch_assoc();
              echo '
                       <h2>
                                    
                            '.     $row['userName'].'

                                    
                                </h2>
                                <p>
                                   תאריך:
                                  
                                    '.$row['date'].'
                                   
                                </p>
                                <div class="rating">
                                    <p>
                                        <span><i class="fa fa-star rated"></i></span>
                                     
                                        <span>מומלץ על ידי המערכת</span>
                                    </p>
                                </div>
                                <p class="product_price" style="font-size:20px; font-weight:400;">
                                    שווי:
                                    
                                     
                                    
                                    <span> '.$row['revenue'].' ₪</span> 
                                    
                                </p>
                                <p class="product_price" style="font-size:20px;  font-weight:400;">
                                   רווח משוער:
                                    
                                     
                                    
                                    <span id="price" style="color:green;  "> '.($row['revenue']/2) 
                                    
                                    .' </span>
                                    <span>
                                    ₪</span> 
                                    
                                    </p>
                                  <p class="product_price" style="font-size:24px; padding:0; margin:0; font-weight:400;" >
                                                                            מחיר לרכישת המיחזור:
                                    <span id="price" style="color:#ffcc00;">
                                   <b>1 ₪</b> 
                                    </span> </p>
                                    <small>
לאחר רכישת המיחזור תקבל את פרטי הקשר של בעל המיחזור, תוכל ליצור איתו קשר ולתאם איתו את איסוף המיחזור.

                                    </small>
                                    <br>
                                     <small>
לאחר שתרכוש את המיחזור, משתמשים אחרים כבר לא יוכלו לצפות בו ולרכוש אותו.
                                    </small>
                               
                                <p><b>זמינות המיחזור:</b> ';
                                
                                if ($row[paid]==0)
                                {
                                    echo '<span style="color:#55CE63; font-weight:bold;">
                                   זמינות מיידית 
                                </span>';
                                }
                                else
                                {
                                     echo '<span style="color:red; font-weight:bold;">
                                   לא זמין למיחזור 
                                </span>';
                                }
                                
                                echo '
                                </p>
                                <div>
                                    
                                        <div id="paypal-button-container"> </div>

                                    
                                <!--    <button type="button" class="btn btn-primary btn-lg">
                                        <i class="fa fa-shopping-cart"></i> Add to cart
                                    </button> -->
                                </div>
              
              
              ';
          }






?>
