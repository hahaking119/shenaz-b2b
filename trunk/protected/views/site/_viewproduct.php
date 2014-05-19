<div class="row">
    <div class="span3">
        <div class="image-box">
            <?php
                if (is_array($images) && !empty($images)) {
                    $this->widget(
                    'ext.cloudzoom.CloudZoom',
                    array(
                        'width' => 10,
                        )
                    );
                ?>
            <a href='<?php echo Yii::app()->createAbsoluteUrl('/uploads/product/original/'.$images[0]->image); ?>' class='cloud-zoom' id='zoom1'
       rel="adjustX: 10, adjustY:-4, softFocus:true , zoomWidth:700 , position:'right'">
        <img src="<?php echo Yii::app()->createAbsoluteUrl('/uploads/product/thumbs/'.$images[0]->image); ?>" alt='' align="left"
             title=""/>
    </a>
            <?php
                foreach($images as $image){
//                        echo CHtml::image(Yii::app()->baseUrl.'/uploads/product/thumbs/'.$image->image, '', array('title'=>''));
//                        $img[] = $image->image;
                    ?>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('/uploads/product/original/'.$image->image); ?>" class='cloud-zoom-gallery'
           title='' rel="useZoom: 'zoom1', smallImage: '<?php echo Yii::app()->createAbsoluteUrl('/uploads/product/thumbs/'.$image->image); ?>' ">
            <img src="<?php echo Yii::app()->createAbsoluteUrl('/uploads/product/thumbs/'.$image->image); ?>" width="100px" alt=""/>
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

        </div>
    </div>
</div>
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
                    <?php echo $product->price; ?>
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
                                <?php echo $companyInformation->website; ?>
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
                                    if($companyInformation->import_export == 0){
                                        echo "Both";                                    
                                    }
                                    elseif($companyInformation->import_export == 1){
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
                            <div class="description">
                                <b><?php echo CHtml::encode($companyInformation->getAttributeLabel('description')); ?>:</b>
                                <?php echo $companyInformation->description; ?>
                            </div>
                        </div>
                        <div class="span6 pull-right">
                            <?php echo CHtml::image(Yii::app()->createAbsoluteUrl('/uploads/company/logo/thumbs/'.$companyInformation->logo), ''); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="tab-pane" id="directory-information">
                <div class="row">
                    <div class="span3">
                        <div class="full_name">
                            <?php
                                if(!empty($directoryInformation->middle_name)){
                                    $full_name = $directoryInformation->first_name." ".$directoryInformation->middle_name." ".$directoryInformation->last_name;
                                }
                                else {
                                    $full_name = $directoryInformation->first_name." ".$directoryInformation->last_name;
                                }
                                echo "<h3>".$full_name."</h3>";
                            ?>
                        </div>
                        <div class="job_title">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('job_title')); ?>:</b>
                            <?php echo $directoryInformation->job_title; ?>
                        </div>
                        <div class="email">
                            <b><?php echo CHtml::encode($directoryInformation->getAttributeLabel('email')); ?>:</b>
                            <?php echo $directoryInformation->email; ?>
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
                    </div>
                    <div class="span6 pull-right">
                        <?php
                            if(!empty($directoryInformation->image)){
                                $img_path = Yii::app()->createAbsoluteUrl('/uploads/directory/image/thumbs/'.$directoryInformation->image);
//                                $img_path = Yii::app()->baseUrl.'/uploads/directory/image/thumbs/'.$directoryInformation->image;
//                                if(file_exists($img_path)){
                                    echo CHtml::image($img_path, '');
//                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="feedbacks">...</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#details a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
    $.fn.CloudZoom.defaults = {
        zoomWidth: 'auto',
        zoomHeight: 'auto',
        position: 'right',
        tint: false,
        tintOpacity: 0.5,
        lensOpacity: 0.5,
        softFocus: false,
        smoothMove: 3,
        showTitle: true,
        titleOpacity: 0.5,
        adjustX: 0,
        adjustY: 0
    };
</script>