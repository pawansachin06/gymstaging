@extends('layouts.mainTable')

@section('content')
  <section class="innerpage-cont body-cont list-deatils">
    <div class="listing-deatils-heading">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-8 col-xl-8">
            <div class="list-thumb-heading"> <img src="{{ asset('/gymselect/images/gym-logo.png') }}" alt=" "> Pure gym, Preston <br/>
              <span>24 Hour Gym</span> </div>
          </div>
          <div class="col-12 col-md-12 col-lg-4 col-xl-4">
            <div class="list-thumb-heading-right"> <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                      class="fas fa-star"></i><br/>
              <strong> 4 <span>(64)</span> </strong> </div>
          </div>
        </div>
      </div>
    </div>
    <div class="listing-deatils-cont">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-8 col-xl-8">
            <div class="list-details-slider">
              <div class="product-slider">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="item active carousel-item"> <img src="http://placehold.it/1600x700?text=Product+01"> </div>
                    <div class="item carousel-item"> <img src="http://placehold.it/1600x700?text=Product+02"> </div>
                    <div class="item carousel-item"> <img src="http://placehold.it/1600x700?text=Product+03"> </div>
                    <div class="item carousel-item"> <img src="http://placehold.it/1600x700?text=Product+04"> </div>
                    <div class="item carousel-item"> <img src="http://placehold.it/1600x700?text=Product+05"> </div>
                    <div class="item carousel-item"> <img src="http://placehold.it/1600x700?text=Product+06"> </div>
                    <div class="item carousel-item"> <img src="http://placehold.it/1600x700?text=Product+07"> </div>
                    <div class="item carousel-item"> <img src="http://placehold.it/1600x700?text=Product+08"> </div>
                    <div class="item carousel-item"> <img src="http://placehold.it/1600x700?text=Product+09"> </div>
                    <div class="item carousel-item"> <img src="http://placehold.it/1600x700?text=Product+10"> </div>
                  </div>
                </div>
                <div class="clearfix">
                  <div id="thumbcarousel" class="carousel slide" data-interval="false">
                    <div class="carousel-inner">
                      <div class="item active carousel-item">
                        <div data-target="#carousel" data-slide-to="0" class="thumb"> <img src="http://placehold.it/100x80?text=Thumb+01"> </div>
                        <div data-target="#carousel" data-slide-to="1" class="thumb"> <img src="http://placehold.it/100x80?text=Thumb+02"> </div>
                        <div data-target="#carousel" data-slide-to="2" class="thumb"> <img src="http://placehold.it/100x80?text=Thumb+03"> </div>
                        <div data-target="#carousel" data-slide-to="3" class="thumb"> <img src="http://placehold.it/100x80?text=Thumb+04"> </div>
                        <div data-target="#carousel" data-slide-to="4" class="thumb"> <img src="http://placehold.it/100x80?text=Thumb+05"> </div>
                      </div>
                      <div class="item carousel-item">
                        <div data-target="#carousel" data-slide-to="5" class="thumb"> <img src="http://placehold.it/100x80?text=Thumb+06"> </div>
                        <div data-target="#carousel" data-slide-to="6" class="thumb"> <img src="http://placehold.it/100x80?text=Thumb+07"> </div>
                        <div data-target="#carousel" data-slide-to="7" class="thumb"> <img src="http://placehold.it/100x80?text=Thumb+08"> </div>
                        <div data-target="#carousel" data-slide-to="8" class="thumb"> <img src="http://placehold.it/100x80?text=Thumb+08"> </div>
                        <div data-target="#carousel" data-slide-to="9" class="thumb"> <img src="http://placehold.it/100x80?text=Thumb+10"> </div>
                      </div>
                    </div>
                    <!-- /carousel-inner --> <a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev"> <i class="fa fa-angle-left" aria-hidden="true"></i> </a> <a
                            class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next"><i class="fa fa-angle-right" aria-hidden="true"></i> </a> </div>
                  <!-- /thumbcarousel -->
                </div>
              </div>
            </div>
            <div class="list-about">
              <h2> About </h2>
              <p> Searching for a new approach to exercise? Do your body and your pocket a big favour by
                getting down to our great-value gym in Preston which hits the right spots. Whether you're
                making your first move towards a healthier lifestyle, exercise frequently or practically live in
                the gym, we have something to suit everyone and every body. We stand out from the rest
                because we offer 24-hour access in a safe environment and there is no contract when you
                become a member so you are free to come and go as you please.</p>
            </div>
            <div class="features-tab">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"> <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">Features</a> </li>
                <li class="nav-item"> <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" aria-selected="false">Class Timetable</a> </li>
                <li class="nav-item"> <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="contact" aria-selected="false">Opening Hours</a> </li>
                <li class="nav-item"> <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="contact" aria-selected="false">Membership Options</a> </li>
                <li class="nav-item"> <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="contact" aria-selected="false">The Team </a> </li>
                <li class="nav-item"> <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="contact" aria-selected="false">Contact </a> </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">
                  <div class="gym-features-list">
                    <ul>
                      <li> <img src="{{ asset('/gymselect/images/features-icon1.png') }}" alt=" "> Free Weights </li>
                      <li> <img src="{{ asset('/gymselect/images/features-icon2.png') }}" alt=" ">Parking </li>
                      <li> <img src="{{ asset('/gymselect/images/features-icon3.png') }}" alt=" "> Wifi </li>
                      <li> <img src="{{ asset('/gymselect/images/features-icon4.png') }}" alt=" "> Running Track</li>
                      <li> <img src="{{ asset('/gymselect/images/features-icon5.png') }}" alt=" "> Showers </li>
                      <li> <img src="{{ asset('/gymselect/images/features-icon6.png') }}" alt=" "> Swimming Pool </li>
                      <li> <img src="{{ asset('/gymselect/images/features-icon7.png') }}" alt=" "> Jacuzzi </li>
                      <li> <img src="{{ asset('/gymselect/images/features-icon8.png') }}" alt=" "> Cardio Machines </li>
                      <li> <img src="{{ asset('/gymselect/images/features-icon9.png') }}" alt=" "> Sauna </li>
                      <li> <img src="{{ asset('/gymselect/images/features-icon10.png') }}" alt=" "> Creche </li>
                    </ul>
                  </div>
                </div>
                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                    <div class="mobile-timetable"> <a href="#" class="btn btn2 btn-block border-radius"> View Class Timetable <i class="fas fa-download" aria-hidden="true"></i> </a> </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="contact-tab">
                  <div class="mobile-hours"> <img src="https://gymselect.local/gymselect/images/hours.png" alt=" "> Open 24 Hours, 7 Days a Week </div>
                </div>
                <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="contact-tab">
                  <div class="row membership-cont">
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                      <div class="card text-center">
                        <div class="card-header card-header1 text-capitalize"> Monthly </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">£12.00</li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                      <div class="card text-center">
                        <div class="card-header card-header1 text-capitalize"> Monthly </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">£12.00</li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                      <div class="card text-center">
                        <div class="card-header card-header1 text-capitalize"> Monthly </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">£12.00</li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                      <div class="card text-center">
                        <div class="card-header card-header1 text-capitalize"> Monthly </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">£12.00</li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                      <div class="card text-center">
                        <div class="card-header card-header1 text-capitalize"> Monthly </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">£12.00</li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                      <div class="card text-center">
                        <div class="card-header card-header1 text-capitalize"> Monthly </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">£12.00</li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6"> <a href="#" class="btn btn1 btn-block border-radius mb-2"> More Information </a> </div>
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6"> <a href="#" class="btn btn2 btn-block border-radius"> Join Now ! </a> </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="contact-tab">
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-6 col-xl-5 list-mobile mt-1">
                      <div class="mobile-team-cont">
                        <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/team1.png" alt=" "> Dan Upton <br>
                          <span>Gym Manager</span> </div>
                        <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                      </div>
                      <div class="mobile-team-cont">
                        <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/team1.png" alt=" "> Dan Upton <br>
                          <span>Gym Manager</span> </div>
                        <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                      </div>
                      <div class="mobile-team-cont">
                        <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/team1.png" alt=" "> Dan Upton <br>
                          <span>Gym Manager</span> </div>
                        <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                      </div>
                      <div class="mobile-team-cont">
                        <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/team1.png" alt=" "> Dan Upton <br>
                          <span>Gym Manager</span> </div>
                        <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                      </div>
                      <div class="mobile-team-cont">
                        <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/team1.png" alt=" "> Dan Upton <br>
                          <span>Gym Manager</span> </div>
                        <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                      </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-1 col-xl-1 spe1">




                    </div>



                    <div class="col-12 col-md-12 col-lg-6 col-xl-5 offset-xl-1 list-mobile mt-1">
                      <div class="mobile-team-cont">
                        <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/team1.png" alt=" "> Dan Upton <br>
                          <span>Gym Manager</span> </div>
                        <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                      </div>
                      <div class="mobile-team-cont">
                        <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/team1.png" alt=" "> Dan Upton <br>
                          <span>Gym Manager</span> </div>
                        <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                      </div>
                      <div class="mobile-team-cont">
                        <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/team1.png" alt=" "> Dan Upton <br>
                          <span>Gym Manager</span> </div>
                        <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                      </div>
                      <div class="mobile-team-cont">
                        <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/team1.png" alt=" "> Dan Upton <br>
                          <span>Gym Manager</span> </div>
                        <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                      </div>
                      <div class="mobile-team-cont">
                        <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/team1.png" alt=" "> Dan Upton <br>
                          <span>Gym Manager</span> </div>
                        <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="contact-tab">

                  <div class="row">

                    <div class="col-12 col-md-12 col-lg-6 col-xl-6"> <a href="#" class="btn btn1 btn-block border-radius mb-2">Visit Site </a> </div>

                    <div class="col-12 col-md-12 col-lg-6 col-xl-6"> <a href="#" class="btn btn2 btn-block border-radius"> Join Now ! </a> </div>

                    <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-social tab-contact-list">
                      <ul>
                        <li> <a href="#"> <img src="https://gymselect.local/gymselect/images/icon1.jpg" alt=" "> https://www.puregym.com/</a> </li>
                        <li> <a href="#"> <img src="https://gymselect.local/gymselect/images/icon3.jpg" alt=" ">0344 477 0005</a> </li>
                        <li> <a href="#"> <img src="https://gymselect.local/gymselect/images/icon5.jpg" alt=" ">info@puregym.com</a> </li>
                        <li> <a href="#"> <img src="https://gymselect.local/gymselect/images/mappin.png" alt=" ">West Granton House, W Granton Rd,</a> </li>
                        <li> <a href="#"> <img src="https://gymselect.local/gymselect/images/icon2.jpg" alt=" "> https://www.facebook.com/puregym</a> </li>
                        <li> <a href="#"> <img src="https://gymselect.local/gymselect/images/icon4.jpg" alt=" ">https://www.twitter.com/puregym</a> </li>
                        <li> <a href="#"> <img src="https://gymselect.local/gymselect/images/icon6.jpg" alt=" ">https://www.instagram.com/puregym  </a></li>
                      </ul>
                    </div>

                  </div>




                </div>
              </div>
            </div>
            <div class="list-comments">
              <h2> What my members say</h2>
              <div class="list-thumb-heading-right text-left"> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> <strong> 4 <span>(64)</span> </strong> </div>
              <p>
                <button class="btn btn3 btn-block"> Add Review</button>
              </p>
              <ul>
                <li>
                  <div class="comments">
                    <div class="user-left"> <img src="{{ asset('/gymselect/images/user.jpg') }}" alt=" "> Kyle Fuller </div>
                    <div class="user-right">
                      <div class="list-thumb-heading-right"> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> </div>
                    </div>
                    <div class="user-texts">
                      <p><strong> Excellent gym!</strong> </p>
                      <p>Puregym is such a great gym, i've been going there a while now and really love it.
                        I've lost over a stone and feel so much stronger thanks to <span> The Body Geek </span> ! </p>
                      <small> 4/10/2019 </small> </div>
                  </div>
                </li>
                <li>
                  <div class="comments">
                    <div class="user-left"> <img src="{{ asset('/gymselect/images/user.jpg') }}" alt=" "> Kyle Fuller </div>
                    <div class="user-right">
                      <div class="list-thumb-heading-right"> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> </div>
                    </div>
                    <div class="user-texts">
                      <p><strong> Excellent gym!</strong> </p>
                      <p>Puregym is such a great gym, i've been going there a while now and really love it.
                        I've lost over a stone and feel so much stronger thanks to <span> The Body Geek </span> ! </p>
                      <small> 4/10/2019 </small> </div>
                  </div>
                </li>
                <li>
                  <div class="comments">
                    <div class="user-left"> <img src="{{ asset('/gymselect/images/user.jpg') }}" alt=" "> Kyle Fuller </div>
                    <div class="user-right">
                      <div class="list-thumb-heading-right"> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> </div>
                    </div>
                    <div class="user-texts">
                      <p><strong> Excellent gym!</strong> </p>
                      <p>Puregym is such a great gym, i've been going there a while now and really love it.
                        I've lost over a stone and feel so much stronger thanks to <span> The Body Geek </span> ! </p>
                      <small> 4/10/2019 </small> </div>
                  </div>
                </li>
                <li>
                  <div class="comments">
                    <div class="user-left"> <img src="{{ asset('/gymselect/images/user.jpg') }}" alt=" "> Kyle Fuller </div>
                    <div class="user-right">
                      <div class="list-thumb-heading-right"> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> </div>
                    </div>
                    <div class="user-texts">
                      <p><strong> Excellent gym!</strong> </p>
                      <p>Puregym is such a great gym, i've been going there a while now and really love it.
                        I've lost over a stone and feel so much stronger thanks to <span> The Body Geek </span> ! </p>
                      <small> 4/10/2019 </small> </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-4 col-xl-4">
            <div class="list-map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2482.243879426833!2d-0.13320128422930722!3d51.527086579638485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761b2515ce0ba1%3A0xbc962779df457f99!2s163%20Euston%20Rd%2C%20Kings%20Cross%2C%20London%20NW1%202BH%2C%20UK!5e0!3m2!1sen!2sin!4v1577962987792!5m2!1sen!2sin" width="100%" height="" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
            </div>
            <div class="othersgym-list">
              <h2> Other Gyms in your area </h2>
              <ul>
                <li>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/gym-logo.png" alt=" "> Pure gym, Preston <br>
                        <span>24 Hour Gym</span> </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                      <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/gym-logo.png" alt=" "> Pure gym, Preston <br>
                        <span>24 Hour Gym</span> </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                      <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/gym-logo.png" alt=" "> Pure gym, Preston <br>
                        <span>24 Hour Gym</span> </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                      <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/gym-logo.png" alt=" "> Pure gym, Preston <br>
                        <span>24 Hour Gym</span> </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                      <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/gym-logo.png" alt=" "> Pure gym, Preston <br>
                        <span>24 Hour Gym</span> </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                      <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/gym-logo.png" alt=" "> Pure gym, Preston <br>
                        <span>24 Hour Gym</span> </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                      <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/gym-logo.png" alt=" "> Pure gym, Preston <br>
                        <span>24 Hour Gym</span> </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                      <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/gym-logo.png" alt=" "> Pure gym, Preston <br>
                        <span>24 Hour Gym</span> </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                      <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/gym-logo.png" alt=" "> Pure gym, Preston <br>
                        <span>24 Hour Gym</span> </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                      <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                      <div class="list-thumb-heading"> <img src="https://gymselect.local/gymselect/images/gym-logo.png" alt=" "> Pure gym, Preston <br>
                        <span>24 Hour Gym</span> </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                      <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <div> </div>
  </section>
@endsection
