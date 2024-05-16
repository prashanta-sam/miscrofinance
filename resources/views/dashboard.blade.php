@extends('layout.app')

@section('title', 'Microfinance')


@section('content')



       <!--start content-->
          <main class="page-content">

             <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
                <div class="col">
                    <div class="card rounded-4">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <p class="mb-1">Total RDs</p>
                            <h4 class="mb-0">{{ env('DB_RUPEE'). $total_rds }}</h4>
                            {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                          </div>
                          <div class="ms-auto widget-icon bg-primary text-white">
                            <i class="bi bi-basket2"></i>
                          </div>
                        </div>

                      </div>
                    </div>
                 </div>
                <div class="col">
                    <div class="card rounded-4">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <p class="mb-1">Total Loan</p>
                            <h4 class="mb-0">{{ env('DB_RUPEE'). $total_loans }}</h4>
                          </div>
                          <div class="ms-auto widget-icon bg-primary text-white">
                            <i class="bi bi-basket2"></i>
                          </div>
                        </div>

                      </div>
                    </div>
                 </div>
                 <div class="col">
                    <div class="card rounded-4">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <p class="mb-1">Total Emis Collection</p>
                            <h4 class="mb-0">{{ env('DB_RUPEE'). $total_emis }}</h4>
                            {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                          </div>
                          <div class="ms-auto widget-icon bg-primary text-white">
                            <i class="bi bi-basket2"></i>
                          </div>
                        </div>

                      </div>
                    </div>
                   </div>
                 <div class="col">
                  <div class="card rounded-4">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <p class="mb-1">Total RD Collection</p>
                          <h4 class="mb-0">{{ env('DB_RUPEE'). $totalCollection }}</h4>
                          {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                        </div>
                        <div class="ms-auto widget-icon bg-primary text-white">
                          <i class="bi bi-basket2"></i>
                        </div>
                      </div>

                    </div>
                  </div>
                 </div>
                 {{-- <div class="col">
                    <div class="card rounded-4">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <p class="mb-1">Total Interest</p>
                            <h4 class="mb-0">{{ env('DB_RUPEE'). $totalInterest }}</h4>
                          </div>
                          <div class="ms-auto widget-icon bg-primary text-white">
                            <i class="bi bi-basket2"></i>
                          </div>
                        </div>

                      </div>
                    </div>
                </div> --}}


                    <div class="col">
                        <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Total Fine</p>
                                <h4 class="mb-0">{{ env('DB_RUPEE'). $totalFine }}</h4>
                                {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                            </div>
                            <div class="ms-auto widget-icon bg-primary text-white">
                                <i class="bi bi-basket2"></i>
                            </div>
                            </div>

                        </div>
                        </div>
                   </div>

                   <div class="col">
                    <div class="card rounded-4">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="">
                            <p class="mb-1">Active customer</p>
                            <h4 class="mb-0">{{ $activeCust}}</h4>
                            {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                          </div>
                          <div class="ms-auto widget-icon bg-primary text-white">
                            <i class="bi bi-basket2"></i>
                          </div>
                        </div>

                      </div>
                    </div>
                   </div>
                   @if($isAdmin)
                    <div class="col">
                            <div class="card rounded-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Active employee</p>
                                    <h4 class="mb-0">{{ $activeStuff}}</h4>
                                    {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                                </div>
                                <div class="ms-auto widget-icon bg-primary text-white">
                                    <i class="bi bi-basket2"></i>
                                </div>
                                </div>

                            </div>
                            </div>
                    </div>
                    @endif


                </div>
                <hr>
                <h2>Today's</h2>
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
                    <div class="col">
                        <div class="card rounded-4">
                          <div class="card-body">
                            <div class="d-flex align-items-center">
                              <div class="">
                                <p class="mb-1">Todays's Total RDs</p>
                                <h4 class="mb-0">{{ env('DB_RUPEE'). $total_rds }}</h4>
                                {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                              </div>
                              <div class="ms-auto widget-icon bg-primary text-white">
                                <i class="bi bi-basket2"></i>
                              </div>
                            </div>

                          </div>
                        </div>
                     </div>
                    <div class="col">
                        <div class="card rounded-4">
                          <div class="card-body">
                            <div class="d-flex align-items-center">
                              <div class="">
                                <p class="mb-1">Today's Total Loan</p>
                                <h4 class="mb-0">{{ env('DB_RUPEE'). $today_loans }}</h4>
                                {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                              </div>
                              <div class="ms-auto widget-icon bg-primary text-white">
                                <i class="bi bi-basket2"></i>
                              </div>
                            </div>

                          </div>
                        </div>
                     </div>

                    <div class="col">
                        <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Today's EMIs Collection</p>
                                <h4 class="mb-0">{{ $today_emi_collection }}</h4>
                                {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                            </div>
                            <div class="ms-auto widget-icon bg-primary text-white">
                                <i class="bi bi-basket2"></i>
                            </div>
                            </div>

                        </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Today's RD Collection</p>
                                <h4 class="mb-0">{{ $today_collection }}</h4>
                                {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                            </div>
                            <div class="ms-auto widget-icon bg-primary text-white">
                                <i class="bi bi-basket2"></i>
                            </div>
                            </div>

                        </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Today's fine</p>
                                <h4 class="mb-0">{{ $today_fine }}</h4>
                                {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                            </div>
                            <div class="ms-auto widget-icon bg-primary text-white">
                                <i class="bi bi-basket2"></i>
                            </div>
                            </div>

                        </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1">Today's new customer</p>
                                <h4 class="mb-0">{{ $today_customer }}</h4>
                                {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                            </div>
                            <div class="ms-auto widget-icon bg-primary text-white">
                                <i class="bi bi-basket2"></i>
                            </div>
                            </div>

                        </div>
                        </div>
                    </div>
                    @if($isAdmin)
                        <div class="col">
                            <div class="card rounded-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                    <div class="">
                                        <p class="mb-1">Today's new employee</p>
                                        <h4 class="mb-0">{{ $today_stuff }}</h4>
                                        {{-- <p class="mb-0 mt-2 font-13"><i class="bi bi-arrow-up"></i><span>22.5% from last week</span></p> --}}
                                    </div>
                                    <div class="ms-auto widget-icon bg-primary text-white">
                                        <i class="bi bi-basket2"></i>
                                    </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!--end row-->






          </main>
       <!--end page main-->

       <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

       <!--Start Back To Top Button-->
		     <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
       <!--End Back To Top Button-->

       <!--start switcher-->

       <!--end switcher-->


@endsection

