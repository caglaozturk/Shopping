@extends('frontend.layouts.master')
@section('head')
<style>
.close {
  float: right;
  font-size: 21px;
  font-weight: bold;
  line-height: 1;
  color: #000;
  text-shadow: 0 1px 0 #fff;
  filter: alpha(opacity=20);
  opacity: .2;
}
.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
  filter: alpha(opacity=50);
  opacity: .5;
}
</style>
@endsection
@section('title', $product->product_name)
@section('content')
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                @foreach($categories as $category)
                    <li><a href="{{ route('category', $category->slug) }}">{{ $category->category_name }}</a></li>
                @endforeach
                <li class="active">{{ $product->product_name }}</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- content-wraper start -->
<div class="content-wraper">
    <div class="container">
        <div class="row single-product-area">
            <div class="col-lg-5 col-md-6">
                <!-- Product Details Left -->
                <div class="product-details-left">
                    <div class="product-details-images slider-navigation-1">
                        <div class="lg-image">
                            <a class="popup-img venobox vbox-item" href="/frontend/images/product/large-size/1.jpg" data-gall="myGallery">
                                <img src="/frontend/images/product/large-size/1.jpg" alt="product image">
                            </a>
                        </div>
                        <div class="lg-image">
                            <a class="popup-img venobox vbox-item" href="/frontend/images/product/large-size/2.jpg" data-gall="myGallery">
                                <img src="/frontend/images/product/large-size/2.jpg" alt="product image">
                            </a>
                        </div>
                        <div class="lg-image">
                            <a class="popup-img venobox vbox-item" href="/frontend/images/product/large-size/3.jpg" data-gall="myGallery">
                                <img src="/frontend/images/product/large-size/3.jpg" alt="product image">
                            </a>
                        </div>
                        <div class="lg-image">
                            <a class="popup-img venobox vbox-item" href="/frontend/images/product/large-size/4.jpg" data-gall="myGallery">
                                <img src="/frontend/images/product/large-size/4.jpg" alt="product image">
                            </a>
                        </div>
                        <div class="lg-image">
                            <a class="popup-img venobox vbox-item" href="/frontend/images/product/large-size/5.jpg" data-gall="myGallery">
                                <img src="/frontend/images/product/large-size/5.jpg" alt="product image">
                            </a>
                        </div>
                        <div class="lg-image">
                            <a class="popup-img venobox vbox-item" href="/frontend/images/product/large-size/6.jpg" data-gall="myGallery">
                                <img src="/frontend/images/product/large-size/6.jpg" alt="product image">
                            </a>
                        </div>
                    </div>
                    <div class="product-details-thumbs slider-thumbs-1">
                        <div class="sm-image"><img src="/frontend/images/product/small-size/1.jpg" alt="product image thumb"></div>
                        <div class="sm-image"><img src="/frontend/images/product/small-size/2.jpg" alt="product image thumb"></div>
                        <div class="sm-image"><img src="/frontend/images/product/small-size/3.jpg" alt="product image thumb"></div>
                        <div class="sm-image"><img src="/frontend/images/product/small-size/4.jpg" alt="product image thumb"></div>
                        <div class="sm-image"><img src="/frontend/images/product/small-size/5.jpg" alt="product image thumb"></div>
                        <div class="sm-image"><img src="/frontend/images/product/small-size/6.jpg" alt="product image thumb"></div>
                    </div>
                </div>
                <!--// Product Details Left -->
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="product-details-view-content pt-60">
                    <div class="product-info">
                        <h2>{{ $product->product_name }}</h2>
                        <span class="product-details-ref">Mağaza: demo_15</span>
                        <div class="rating-box pt-20">
                            <ul class="rating rating-with-review-item">
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                <li class="review-item"><a href="#reviews">Yorumlar</a></li>
                                <li class="review-item"><a href="#" data-toggle="modal" data-target="#mymodal">Yorum Yaz</a></li>
                            </ul>
                        </div>
                        <div class="price-box pt-20">
                            <span class="new-price new-price-2">${{ $product->price }}</span>
                        </div>
                        <div class="product-desc">
                            <p><span>{{ $product->description }}</span></p>
                        </div>
                        <div class="product-variants">
                            <div class="produt-variants-size">
                                <label>Dimension</label>
                                <select class="nice-select">
                                    <option value="1" title="S" selected="selected">40x60cm</option>
                                    <option value="2" title="M">60x90cm</option>
                                    <option value="3" title="L">80x120cm</option>
                                </select>
                            </div>
                        </div>
                        <div class="product-additional-info pt-25">
                            <a class="wishlist-btn" href="wishlist.html"><i class="fa fa-heart-o"></i>Add to wishlist</a>
                        </div>
                        <div class="single-add-to-cart">
                            <form action="{{ route('shopping_add') }}" method="POST" class="cart-quantity">
                                @csrf
                                <div class="quantity">
                                    <label>Quantity</label>
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" value="1" type="text">
                                        <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                        <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <button class="add-to-cart" type="submit">Sepete Ekle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wraper end -->
<!-- Begin Product Area -->
<div class="product-area pt-35">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li><a class="active" data-toggle="tab" href="#description"><span>Description</span></a></li>
                        <li><a data-toggle="tab" href="#product-details"><span>Product Details</span></a></li>
                        <li><a data-toggle="tab" href="#reviews"><span>Reviews</span></a></li>
                    </ul>
                </div>
                <!-- Begin Li's Tab Menu Content Area -->
            </div>
        </div>
        <div class="tab-content">
            <div id="description" class="tab-pane active show" role="tabpanel">
                <div class="product-description">
                    <span>The best is yet to come! Give your walls a voice with a framed poster. This aesthethic, optimistic poster will look great in your desk or in an open-space office. Painted wooden frame with passe-partout for more depth.</span>
                </div>
            </div>
            <div id="product-details" class="tab-pane" role="tabpanel">
                <div class="product-details-manufacturer">
                    <a href="#">
                        <img src="/frontend/images/product-details/1.jpg" alt="Product Manufacturer Image">
                    </a>
                    <p><span>Reference</span> demo_7</p>
                    <p><span>Reference</span> demo_7</p>
                </div>
            </div>
            <div id="reviews" class="tab-pane" role="tabpanel">
                <div class="product-reviews">
                    <div class="product-details-comment-block">
                        <div class="comment-review">
                            <span>Grade</span>
                            <ul class="rating">
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                            </ul>
                        </div>
                        <div class="comment-author-infos pt-25">
                            <span>HTML 5</span>
                            <em>01-12-18</em>
                        </div>
                        <div class="comment-details">
                            <h4 class="title-block">Demo</h4>
                            <p>Plaza</p>
                        </div>
                        <div class="review-btn">
                            <a class="review-links" href="#" data-toggle="modal" data-target="#mymodal">Write Your Review!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Area End Here -->

<!-- Begin Quick View | Modal Area -->
<div class="modal fade modal-wrapper" id="mymodal" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <a href="#" class="close custom-modal-close-button m-2 text-white" data-dismiss="modal" aria-label="Close">&times;</a>
                <h3 class="review-page-title">Yorum Yaz</h3>
                <div class="modal-inner-area row">
                    <div class="col-lg-6">
                        <div class="li-review-product">
                            <img src="/frontend/images/product/large-size/3.jpg" alt="Li's Product">
                            <div class="li-review-product-desc">
                                <p class="li-product-name">Title</p>
                                <p>
                                    <span>Beach Camera Exclusive Bundle - Includes Two Samsung Radiant 360 R3 Wi-Fi Bluetooth Speakers. Fill The Entire Room With Exquisite Sound via Ring Radiator Technology. Stream And Control R3 Speakers Wirelessly With Your Smartphone. Sophisticated, Modern Design </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="li-review-content">
                            <!-- Begin Feedback Area -->
                            <div class="feedback-area">
                                <div class="feedback">
                                    <h3 class="feedback-title">Geri Bildirim</h3>
                                    <form action="{{ route('commentSave') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <p class="your-opinion">
                                            <label>Değerlendir</label>
                                            <span>
                                                <select class="star-rating" name="star_rating">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </span>
                                        </p>
                                        <p class="feedback-form">
                                            <label for="feedback">Düşünceleriniz</label>
                                            <textarea id="feedback" name="comment" required cols="45" rows="10" aria-required="true"></textarea>
                                        </p>
                                        <div class="feedback-input">
                                            <div class="feedback-btn pb-15">
                                                <input class="mb-2" type="submit" value="Gönder">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Feedback Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quick View | Modal Area End Here -->
@endsection
