@extends('layouts.mainTable')

@section('content')
<section class="innerpage-cont body-cont list-deatils list-mobile">
  <div class="product-slider"> <img src="{{ asset('/gymselect/images/gym-thumb.jpg') }}" alt=" "> </div>
  <div class="listing-deatils-heading">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
          <div class="list-thumb-heading"> <img src="{{ asset('/gymselect/images/gym-logo.png') }}" alt=" "> Pure gym, Preston <br/>
            <span>24 Hour Gym</span> </div>
          <div class="list-thumb-heading-right"> <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
              class="fas fa-star"></i><br/>
            <strong> 4 <span>(64)</span> </strong> </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 col-xl-12">
          <p> <a href="#" class="btn btn1 btn-block"> Add Review</a> </p>
          <p> <a href="#" class="btn btn2 btn-block"> Visit Site</a> </p>
        </div>
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-social">
          <ul>
            <li> <a href="#"> <img src="{{ asset('/gymselect/images/icon1.jpg') }}" alt=" "></a> </li>
            <li> <a href="#"> <img src="{{ asset('/gymselect/images/icon3.jpg') }}" alt=" "></a> </li>
            <li> <a href="#"> <img src="{{ asset('/gymselect/images/icon5.jpg') }}" alt=" "></a> </li>
            <li> <a href="#"> <img src="{{ asset('/gymselect/images/mappin.png') }}" alt=" "></a> </li>
            <li> <a href="#"> <img src="{{ asset('/gymselect/images/icon2.jpg') }}" alt=" "></a> </li>
            <li> <a href="#"> <img src="{{ asset('/gymselect/images/icon4.jpg') }}" alt=" "></a> </li>
            <li> <a href="#"> <img src="{{ asset('/gymselect/images/icon6.jpg') }}" alt=" "></a> </li>
          </ul>
        </div>
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
          <div class="row">
            <div class="mobile-section-heading"> Features </div>
          </div>
          <div class="mobile-features-list">
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
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
          <div class="row">
            <div class="mobile-section-heading"> Media </div>
          </div>
          <div class="mobile-media-slider">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active"> <img src="{{ asset('/gymselect/images/gym-thumb.jpg') }}" alt=" "> </div>
                <div class="carousel-item"> <img src="{{ asset('/gymselect/images/gym-thumb.jpg') }}" alt=" "> </div>
                <div class="carousel-item"> <img src="{{ asset('/gymselect/images/gym-thumb.jpg') }}" alt=" "> </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
          <div class="row">
            <div class="mobile-section-heading"> About </div>
          </div>
          <div class="mobile-about-txt">
            <p> Searching for a new approach to exercise? Do
              your body and your pocket a big favour by getting
              down to our great-value gym in Preston
              which hits the right spots.
              Whether you're making your first move towarrds
              a healthier lifestyle, exercise frequently or
              practically live in the gym, we have something
              to suit everyone and every body. Whether
              you're making your first move towar- rds a
              healthier lifestyle, exercise frequently or pra...</p>
            <p>
              <button class="btn btn3 btn-block radius"> Read More</button>
            </p>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
          <div class="row">
            <div class="mobile-section-heading">Opening Hours</div>
          </div>
          <div class="mobile-hours">
            <p> <img src="{{ asset('/gymselect/images/hours.png') }}" alt=" "> Open 24 Hours, 7 Days a Week</p>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
          <div class="row">
            <div class="mobile-section-heading">Membership Options</div>
          </div>
          <div class="mobile-membership">
            <div class="card text-center">
              <div class="card-header card-header1 text-capitalize"> Monthly </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">£12.00</li>
              </ul>
            </div>
            <div class="card text-center">
              <div class="card-header card-header1 text-capitalize"> Day Pass </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">£5.99</li>
              </ul>
            </div>
            <div class="card text-center">
              <div class="card-header card-header1 text-capitalize"> 12 Months </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">£155.88</li>
              </ul>
            </div>
            <p>
              <button class="btn btn3 btn-block radius"> Join Now</button>
            </p>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
          <div class="row">
            <div class="mobile-section-heading">Meet The Team</div>
          </div>
          <div class="mobile-team">
            <div class="mobile-team-cont">
              <div class="list-thumb-heading"> <img src="{{ asset('/gymselect/images/team1.png') }}" alt=" "> Dan Upton <br>
                <span>Gym Manager</span> </div>
              <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
            </div>
            <div class="mobile-team-cont">
              <div class="list-thumb-heading"> <img src="{{ asset('/gymselect/images/team1.png') }}" alt=" "> Dan Upton <br>
                <span>Gym Manager</span> </div>
              <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
            </div>
            <div class="mobile-team-cont">
              <div class="list-thumb-heading"> <img src="{{ asset('/gymselect/images/team1.png') }}" alt=" "> Dan Upton <br>
                <span>Gym Manager</span> </div>
              <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
            </div>
            <div class="mobile-team-cont">
              <div class="list-thumb-heading"> <img src="{{ asset('/gymselect/images/team1.png') }}" alt=" "> Dan Upton <br>
                <span>Gym Manager</span> </div>
              <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
            </div>
            <div class="mobile-team-cont">
              <div class="list-thumb-heading"> <img src="{{ asset('/gymselect/images/team1.png') }}" alt=" "> Dan Upton <br>
                <span>Gym Manager</span> </div>
              <div class="list-thumb-heading-right"> <a href="#" class="btn btn2"> View </a> </div>
            </div>
          </div>
        </div>



        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
          <div class="row">
            <div class="mobile-section-heading">Class Timetable</div>
          </div>

          <div class="mobile-timetable">

<p> <a href="#" class="btn btn2 btn-block"> View Class Timetable <i class="fas fa-download"></i> </a> </p>
            
          </div>
         
          
        </div>


        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
          <div class="row">
            <div class="mobile-section-heading">View Location</div>
          </div>

          <div class="mobile-map">

            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d4964.48771301932!2d-0.131013!3d51.527087!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761b2515ce0ba1%3A0xbc962779df457f99!2s163%20Euston%20Rd%2C%20Kings%20Cross%2C%20London%20NW1%202BH%2C%20UK!5e0!3m2!1sen!2sin!4v1578057793204!5m2!1sen!2sin" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
            
            
          </div>

          <div class="mobile-address">
            
            Unit 2 & 3, North Road Retail Park, Preston PR1
            1NQ
          </div>
          
         
          
        </div>



        
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mobile-section">
          <div class="row">
            <div class="mobile-section-heading">What our members say</div>
          </div>
          <div class="list-comments">
            
            <div class="list-comments-count"> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> Rated 5 by 27 People </div>

            <p>
              <button class="btn btn3 btn-block"> Add Review</button>
            </p>
            
            <ul>
              <li>
                <div class="comments">
                  <div class="user-left"> <img src="{{ asset('/gymselect/images/user.jpg') }}" alt=" "> Kyle Fuller </div>
                  <div class="user-right">
                    <div class=""> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> </div>
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
                    <div class=""> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> </div>
                  </div>
                  <div class="user-texts">
                    <p><strong> Excellent gym!</strong> </p>
                    <p>Puregym is such a great gym, i've been going there a while now and really love it.
                      I've lost over a stone and feel so much stronger thanks to <span> The Body Geek </span> ! </p>
                    <small> 4/10/2019 </small> </div>
                </div>
              </li>

              <li>
                <div class="comments reply">
                  <div class="user-left"> <img src="{{ asset('/gymselect/images/gym-logo.png') }}" alt=" ">PureGym Preston </div>
            
                  <div class="user-texts">
                   
                    <p>Thank you for the feedback! See you
                      soon!  </p>
                 </div>
                </div>
              </li>


              <li>
                <div class="comments">
                  <div class="user-left"> <img src="{{ asset('/gymselect/images/user.jpg') }}" alt=" "> Kyle Fuller </div>
                  <div class="user-right">
                    <div class=""> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> </div>
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
                    <div class=""> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> </div>
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
                    <div class=""> <i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i><i class="fas fa-star" aria-hidden="true"></i> </div>
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


      </div>
    </div>
  </div>

  </div>
  <div> </div>
</section>
@endsection 