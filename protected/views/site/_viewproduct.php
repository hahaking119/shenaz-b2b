<div class="statusMsg"></div>
<div class="row">
    <div class="span3">
        <div class="image-box">
            <?php
            if (is_array($images) && !empty($images)) {
                $this->widget(
                        'ext.cloudzoom.CloudZoom', array()
                );
                ?>
                <a href='<?php echo Yii::app()->createAbsoluteUrl('/uploads/product/original/' . $images[0]->image); ?>' class='cloud-zoom' id='zoom1'
                   rel="adjustX: 10, adjustY:-4, softFocus:false, tint: false , tintOpacity: 0.5 , variableMagnification: true , zoomWidth:500 , position:'right'">
                    <img src="<?php echo Yii::app()->createAbsoluteUrl('/uploads/product/thumbs/' . $images[0]->image); ?>" alt='' align="left"
                         title=""/>
                </a>
                <?php
                foreach ($images as $image) {
                    ?>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('/uploads/product/original/' . $image->image); ?>" class='cloud-zoom-gallery'
                       title='' rel="useZoom: 'zoom1', smallImage: '<?php echo Yii::app()->createAbsoluteUrl('/uploads/product/thumbs/' . $image->image); ?>' ">
                        <img src="<?php echo Yii::app()->createAbsoluteUrl('/uploads/product/thumbs/' . $image->image); ?>" width="100px" alt=""/>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="span6">
        <h3><?php echo $product->name; ?></h3>
        <div class="price">
            <strong>Price: </strong>
            <?php
            $member_id = $companyInformation->member_id;
            echo CommonClass::getPriceFormat($member_id) . ' ' . $product->price;
            ?> / per unit.
        </div>
        <div class="add-to-cart">
            <?php echo CHtml::form('', 'post', array('id' => 'add-to-cart-form')) ?>
            <?php // echo CHtml::textField('qty','',array('id' => 'quantity','placeholder' => 'Quantity', 'style' => 'width: 60px')); ?>
            <?php echo CHtml::hiddenField('product_id', $product->product_id); ?>
            <?php echo CHtml::numberField('qty', '1', array('id' => 'quantity', 'size' => 3, 'class' => 'span1 pull-left', 'name' => 'amount', 'min' => 1)); ?>
            <?php // echo CHtml::ajaxButton('Add to cart', array('site/add_to_cart', 'product_id' => $product->product_id, 'qty' => 'js:function(){$("#quantity").val();}'), '', array('class' => "btn btn-default", 'style'=>'margin-bottom: 10px')); ?>
            <?php echo CHtml::button('Add to cart', array('id' => 'add-btn', 'class' => "btn btn-default", 'style'=>'margin-bottom: 10px', 'onclick' => 'Add2Cart();')); ?>
            <?php echo CHtml::endForm() ?>
        </div>
        <div class="rating">
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'product-rating-form',
                    'enableAjaxValidation'=>false,
                )); ?>

                        <?php
                            if(!empty($totalRating)){
                                $sum = 0;
                                $vote_sum = 0;
                                foreach($totalRating as $rate)
                                {
                                    $sum = $sum + $rate->rating;
                                }
                                foreach($rating as $vote){
                                    $vote_sum = $vote_sum + $vote->rating;
                                }
                                $ratingPercentage = ($vote_sum/$sum)*100;
                                $value = ($ratingPercentage/100)*5;
                            }
                                $this->widget('CStarRating',array(
                                          'name'=>'star-rating',
                                          'value'=>  round($value),
                                          'minRating'=>1,
                                          'maxRating'=>5,
                                          'starCount'=>5,
                                          'allowEmpty'=>FALSE,
                                          'readOnly'=>Yii::app()->user->isGuest? TRUE : FALSE,
                                          'callback'=>'function(){
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "'.CController::createUrl('rate').'",
                                                            data: "rating=" + $(this).val()+"&product_id='.$product->product_id.'+&company_id='.$companyInformation->company_id.'",
                                                            success: function(data){
                                            }})}'

                                        ));
                                               ?>

                <?php $this->endWidget(); ?>
        </div>
        <div class="contact">
            <?php
                $this->widget('application.extensions.fancybox.EFancyBox', array(
                'target'=>'#rrr',
                'config'=>array(),
                    )
                );
            ?>
            <?php echo CHtml::link('Contact Supplier', '#contact-form', array('id' => 'rrr')); ?>
            <div id="contact-form" style="display: none;">
                <?php echo CHtml::form('', 'post', array('id' => 'contact-form')) ?>
                    Email:
                    <?php
                        if(!Yii::app()->user->isGuest){
                            $member_id = UserIdentity::getMemberId();
                            $member = Member::model()->findByPk($member_id);
                            $email_value = $member->email;
                        }
                        else
                            $email_value = ""
                    ?>
                    <?php echo CHtml::textField('email', $email_value, array('id'=> 'email-input', 'placeholder' => 'Email', 'readonly'=>$email_value? true : FALSE, 'type' => 'email')); ?>
                    <div class="email-error"></div>
                    <br/>
                    <?php echo CHtml::hiddenField('to',$product->company->member_id); ?>
                    Subject:
                    <?php echo CHtml::textField('subject', '', array('id'=> 'subject-input', 'placeholder' => 'Subject')); ?>
                    <div class="subject-error"></div>
                    <br/>
                    Message:
                    <?php echo CHtml::textArea('message', '', array('id'=> 'message-input')); ?>
                    <div class="message-error"></div>
                    <br/>
                    <?php $this->widget('CCaptcha'); ?>
                    <?php echo CHtml::textField('verifyCode', '', array('id' => 'captcha-input')); ?>
                    <div class="verifyCode-error"></div>
                    <br/>
                    <?php echo CHtml::ajaxSubmitButton('Send', array('site/quot'), array(
                                               'type'=>'POST',
//                                               'dataType'=>'json',
                                               'beforeSend'=>'js:function(){
                                                   var error = 0;
                                                   var email = $("#email-input").val();
                                                   if(email === ""){
                                                       $(".email-error").html("Email cannot be blank");
                                                       error = error + 1;
                                                   }
                                                   else{
                                                       $(".email-error").html("");
                                                   }
                                                   var subject = $("#subject-input").val();
                                                   if(subject === ""){
                                                   $(".subject-error").html("Subject cannot be blank");
                                                   error = error + 1;
                                                   }
                                                   else{
                                                       $(".subject-error").html("");
                                                   }
                                                   var message = $("#message-input").val();
                                                   if(message === ""){
                                                   $(".message-error").html("Message cannot be blank");
                                                   error = error + 1;
                                                   }
                                                   else{
                                                       $(".message-error").html("");
                                                   }
                                                   var captcha = $("#captcha-input").val();
                                                   if(captcha === ""){
                                                   $(".verifyCode-error").html("Captcha cannot be blank");
                                                   error = error + 1;
                                                   }
                                                   else{
                                                       $(".verifyCode-error").html("");
                                                   }
                                                   if(error>0){
                                                   return;
                                                   }
                                                }',
                                               'complete'=>'js:function(data){
                                                   }',
                                               'success'=>'js:function(data){
                                                   var text = JSON.parse(data);
                                                   if(text.result==="success"){
                                                      $.fancybox.close();
                                                      $("#form_quot").trigger("reset");
                                                   }
                                                   else if(text.result === "incorrectCaptcha"){
                                                     $(".verifyCode-error").html("Incorrect Captcha");
                                                   }
                                               }',
                                            ), array('class' => "btn btn-default", 'style'=>'margin-bottom: 10px')); ?>
                <?php echo CHtml::endForm() ?>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="span9">
        <ul class="nav nav-tabs" id="details">
            <li class="active"><a href="#detail">Product Details</a></li>
            <li><a href="#company-information">Company Profile</a></li>
            <li><a href="#directory-information">Directory Information</a></li>
            <li><a href="#feedbacks">Feedbacks</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="detail">
                <h3><?php echo $product->name; ?></h3>
                <div class="description">
                    <?php echo $product->description; ?>
                </div>
                <div class="price">
                    <b><?php echo CHtml::encode($product->getAttributeLabel('price')); ?>:</b>
                    <?php echo CommonClass::getPriceFormat($member_id) . ' ' . $product->price;
                    ?> / per unit.
                </div>
                <div class="sku">
                    <b><?php echo CHtml::encode($product->getAttributeLabel('sku')); ?>:</b>
                    <?php echo $product->sku; ?>
                </div>
                <div class="stock">
                    <b><?php echo CHtml::encode($product->getAttributeLabel('stock')); ?>:</b>
                    <?php echo $product->stock; ?>
                </div>
            </div>
            <div class="tab-pane" id="company-information">
                <?php if (!empty($companyInformation)) { ?>
                    <div class="row">
                        <div class ="span3">
                            <h3><?php echo $companyInformation->company_name; ?></h3>
                            <div class="description">
                                <?php echo $companyInformation->description; ?>
                            </div>
                            <div class="location">
                                <b><?php echo CHtml::encode($companyInformation->getAttributeLabel('company_location')); ?>:</b>
                                <?php echo $companyInformation->company_location; ?>
                            </div>
                            <div class="country">
                                <b><?php echo CHtml::encode($companyInformation->getAttributeLabel('country_of_origin')); ?>:</b>
                                <?php echo $companyInformation->country_of_origin; ?>
                            </div>
                            <div class="website">
                                <b><?php echo CHtml::encode($companyInformation->getAttributeLabel('website')); ?>:</b>
                                <?php echo CHtml::link($companyInformation->website, 'http://' . $companyInformation->website); ?>
                            </div>
                            <div class="established_at">
                                <b><?php echo CHtml::encode($companyInformation->getAttributeLabel('established_at')); ?>:</b>
                                <?php echo $companyInformation->established_at; ?>
                            </div>
                            <div class="active_business_years">
                                <b><?php echo CHtml::encode($companyInformation->getAttributeLabel('active_business_years')); ?>:</b>
                                <?php echo $companyInformation->active_business_years; ?>
                            </div>
                            <div class="import_export">
                                <b><?php echo CHtml::encode($companyInformation->getAttributeLabel('import_export')); ?>:</b>
                                <?php
                                if ($companyInformation->import_export == 0) {
                                    echo "Both";
                                } elseif ($companyInformation->import_export == 1) {
                                    echo "Export";
                                }
                                else
                                    echo "Import";
                                ?>
                            </div>
                            <div class="no_of_staffs">
                                <b><?php echo CHtml::encode($companyInformation->getAttributeLabel('no_of_staffs')); ?>:</b>
                                <?php echo $companyInformation->no_of_staffs; ?>
                            </div>
                        </div>
                        <div class="span6 pull-right">
                            <?php echo CHtml::image(Yii::app()->createAbsoluteUrl('/uploads/company/logo/thumbs/' . $companyInformation->logo), ''); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="tab-pane" id="directory-information">
                <div class="row">
                    <div class="span3">
                        <div class="full_name">
                            <?php
                            if (!empty($directoryInformation->middle_name)) {
                                $full_name = $directoryInformation->first_name . " " . $directoryInformation->middle_name . " " . $directoryInformation->last_name;
                            } else {
                                $full_name = $directoryInformation->first_name . " " . $directoryInformation->last_name;
                            }
                            echo "<h3>" . $full_name . "</h3>";
                            ?>
                        </div>
                        <div class="job_title">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('job_title')); ?>:</b>
                            <?php echo $directoryInformation->job_title; ?>
                        </div>
                        <div class="address">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('address')); ?>:</b>
                            <?php echo $directoryInformation->address; ?>
                        </div>
                        <div class="area">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('area')); ?>:</b>
                            <?php echo $directoryInformation->area; ?>
                        </div>
                        <div class="province">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('province')); ?>:</b>
                            <?php echo $directoryInformation->province; ?>
                        </div>
                        <div class="country">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('country')); ?>:</b>
                            <?php echo $directoryInformation->country; ?>
                        </div>
                        <div class="phone">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('phone')); ?>:</b>
                            <?php echo $directoryInformation->phone; ?>
                        </div>
                        <div class="fax">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('fax')); ?>:</b>
                            <?php echo $directoryInformation->fax; ?>
                        </div>
                        <div class="zip_code">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('zip_code')); ?>:</b>
                            <?php echo $directoryInformation->zip_code; ?>
                        </div>
                        <div class="email">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('email')); ?>:</b>
                            <?php echo $directoryInformation->email; ?>
                        </div>
                    </div>
                    <div class="span6 pull-right">
                        <?php
                        if (!empty($directoryInformation->image)) {
                            $img_path = Yii::app()->createAbsoluteUrl('/uploads/directory/image/thumbs/' . $directoryInformation->image);
//                                $img_path = Yii::app()->baseUrl.'/uploads/directory/image/thumbs/'.$directoryInformation->image;
//                                if(file_exists($img_path)){
                            echo CHtml::image($img_path, '');
//                                }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="feedbacks">
                <div class="all-feedbacks">
                    <h3><u>Feedbacks</u></h3>
                    <hr style="margin-top: -10px">
                    <?php
                        foreach($allFeedbacks as $suggestion){
                            ?>
                    <div class="one-feedback">
                    <?php
                            echo "<font size='3px'>".$suggestion->feedback."</font><br/>";
                            if (!empty($suggestion->member->middle_name)) {
                                $full_name = $suggestion->member->first_name . " " . $suggestion->member->middle_name . " " . $suggestion->member->last_name;
                            } else {
                                $full_name = $suggestion->member->first_name . " " . $suggestion->member->last_name;
                            }
                            echo "<p align='right'><font size='1px'>".$full_name."</font></p><br/><hr>";
                            ?>
                        </div>
                    <?php
                        }
                    ?>
                </div>
                <?php 
                    if(!Yii::app()->user->isGuest){
                        $this->widget('application.extensions.fancybox.EFancyBox', array(
                            'target'=>'#feedback-link',
                            'config'=>array(),
                                )
                            );
                        echo CHtml::link('Write Feedback', '#feedback-form-div', array('id' => 'feedback-link'));
                
                        ?>
                        <div  id="feedback-form-div" style="display: none;">
                            <?php
                                $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                    'id'=>'feedback-form',
                                    'action'=>'site/feedback',
                                    'enableClientValidation'=>true,
                                    'clientOptions'=>array(
                                            'validateOnSubmit'=>true,
                                    ),
                                    )); ?>
                                    <?php echo $form->hiddenField($feedback, 'product_id'); ?>
                                    <?php echo $form->hiddenField($feedback, 'company_id'); ?>

                                    <?php echo $form->textAreaRow($feedback,'feedback', array('id' => 'feedback-input')); ?>
                                    <div class="feedback-error"></div>
                                    <br/>

                                    <?php echo CHtml::ajaxSubmitButton('Submit', array('site/feedback'), array(
                                               'type'=>'POST',
                                               'beforeSend'=>'js:function(){
                                                   var feedback = $("#feedback-input").val();
                                                   if(feedback === ""){
                                                   $(".feedback-error").html("Feedback cannot be blank");
                                                   return;
                                                   }
                                                }',
                                               
                                               'complete'=>'js:function(data){
                                                   }',
                                               'success'=>'js:function(data){
                                                       response = JSON.parse(data);
                                                       if(response.status === "success"){
                                                           var feedback = response.feedback;
                                                           var proper_feedback = nl2br(feedback);
                                                           $(".all-feedbacks").append("<font size=\"3px\">"+proper_feedback+"</font><br/>");
                                                           $(".all-feedbacks").append("<p align=\"right\"><font size=\"1px\">"+response.member+"</font></p><br/>");
                                                           $("#feedback-form").trigger("reset");
                                                           $.fancybox.close();
                                                       }
                                                   }',
                                            ),
                                            array('class' => 'btn btn-default')
                                            ); 
                                    ?>
                            <?php $this->endWidget(); ?>
                        </div><!-- form -->
                    <?php
                    }
                    ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#details a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
    
    function Add2Cart(){
        var data = $('#add-to-cart-form').serialize();
        $('#add-btn').val('Adding ... ').attr('disabled', true);
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl("site/Add_to_cart"); ?>',
            data: data,
            success:function(data){
            if(data == 'illegal'){
            data = '<strong>Illegal quantity given.</strong>';
            $("#statusMsg").html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut("slow");
            }else{
            $('#shopcart').load('<?php echo $this->createUrl("/site/getcart"); ?>');
            $("#statusMsg").html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut("slow");
            }
            },
            complete: function(){
            $('#add-btn').val('Add to Cart').attr('disabled', false);
            },
            error: function(data) { // if error occured
            alert("Error occured.please try again");
            },

            dataType:'html'
            });
    }
</script>
<?php
    //This is the way to create session.
//    Yii::app()->session['name']="sudeep";
//    echo Yii::app()->session['name']
?>