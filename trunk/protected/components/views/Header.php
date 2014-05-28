<div class="top-header">
    <div class="container">
        <div class="row">
            <div class="span6">
                Welcome to our SITE <a href="javascript:void(0);"><strong>Join Free</strong></a> | <a href="javascript:void(0);">Sign In</a>
                <span style="color: #E62E04">VIP WIN $600</span>
            </div>
            <div class="span6">
                <ul class="menu pull-right">
                    <li><a href="javascript:void(0);">Our Site<span class="caret"></span></a></li>
                    <li><a href="javascript:void(0);">Community<span class="caret"></span></a></li>
                    <li><a href="javascript:void(0);">Help<span class="caret"></span></a></li>
                    <li><a href="javascript:void(0);">VIP Club</a></li>
                    <li><a href="javascript:void(0);">Language</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="bottom-header">
    <div class="container">
        <div class="row">
            <div class="span4">
                <!--<img src="<?php echo Yii::app()->createAbsoluteUrl(''); ?>" alt="b2b logo">-->
                <a href="<?php echo Yii::app()->createAbsoluteUrl('site'); ?>">B2B Logo</a>
            </div>
            <div class="<?php if(Yii::app()->user->isGuest){echo "span8";}else{echo "span9";} ?> search-bar pull-right">
                <ul>
                    <li class="search-form">
                        <div class="input-append">
                            <input type="text" name="Search[text]" class="form-control span3" placeholder="I'm shopping for ...">

                            <span class="add-on">
                                <?php echo chtml::dropDownList('Search[category]', '', array('' => 'All Categories') + CHtml::listData($categories, 'category_id', 'title')); ?>
                            </span>
                            <input class="search-button" type="submit" value="Search">
                        </div>
                    </li>
                    <li class="nav-cart span1">
                        <a id="shop-cart" rel="nofollow" href="javascript:void(0);">Cart</a>
                        <span id="nav-cart-num" style="display:none">0</span>
                        <div id="shopcart">
                            <?php
                            $this->widget('application.components.ShoppingCartWidget');
                            ?>
                        </div>
                    </li>
                    <li class="nav-wishlist">
                        <a id="wish-list" rel="nofollow" href="javascript:void(0);">Wish List</a>
                    </li>
                    <li class="dropdown-login-box pull-right">
                        <?php
                        if (Yii::app()->user->isGuest) {
                            ?>
                            <a href="<?php echo Yii::app()->createAbsoluteUrl('site/login'); ?>">Sign In</a>
                            <?php
                        } else {
                            echo Chtml::link('View Inquiry',Yii::app()->createAbsoluteUrl('inquiry/admin'));
                            ?>|
                            <a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>">Logout</a>
                            <?php
                        }
                        ?>| <a href="javascript:void(0);">Join</a><span class="caret"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>