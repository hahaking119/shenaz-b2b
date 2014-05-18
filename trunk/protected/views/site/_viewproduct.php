<div class="row">
    <div class="span3">
        <div class="image-box">
            <?php
            if (is_array($images)) {
                
            }
            ?>
        </div>
    </div>
    <div class="span6">
        <h3><?php echo $product->name; ?></h3>
        <div class="price">
            <strong>Price: </strong>
            <?php
            $member_id = $comopanyInformation->member_id;
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
            <li class="active"><a href="#details">Product Details</a></li>
            <li><a href="#company-information">Company Profile</a></li>
            <li><a href="#directory-information">Contact</a></li>
            <li><a href="#feedbacks">Feedbacks</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="details">
                <h3><?php echo $product->name; ?></h3>
                <div class="description">
                    <?php echo $product->description; ?>
                </div>
            </div>
            <div class="tab-pane" id="company-information">
                <?php if (!empty($companyInformation)) { ?>
                    <div class="row">
                        <div class ="span3">
                            <h3><?php echo $comopanyInformation->company_name; ?></h3>
                        </div>
                        <div class="span6 pull-right">
                            <?php echo CHtml::image(Yii::app()->createAbsoluteUrl($comopanyInformation->logo), ''); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="tab-pane" id="directory-information">...</div>
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
</script>
