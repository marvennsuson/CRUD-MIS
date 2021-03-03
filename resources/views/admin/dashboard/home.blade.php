@extends('layouts.dashboard')

@section('header')
    Dashboard
@endsection
@section('content')

<div class="row align-items-stretch">
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-header card-header-warning card-header-icon">
        <div class="card-icon">
          <i class="material-icons">weekend</i>
        </div>
        <p class="card-category">New
        </p>
        <h3 class="card-title">{{ $count_bp['new'] }}</h3>
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="material-icons text-danger">warning</i><a href="#pablo">New Applications</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-header card-header-rose card-header-icon">
        <div class="card-icon">
          <i class="material-icons">equalizer</i>
        </div>
        <p class="card-category">Renewal
        </p>
        <h3 class="card-title">{{ $count_bp['renewal'] }}</h3>
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="material-icons">local_offer</i> Business Permit Renewal
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-header card-header-success card-header-icon">
        <div class="card-icon">
          <i class="material-icons">store</i>
        </div>
        <p class="card-category">Location</p>
        <h3 class="card-title">{{ $count_bp['tobl'] }}</h3>
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="material-icons">date_range</i> Transfer of Location
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-header card-header-info card-header-icon">
        <div class="card-icon">
          <i class="fa fa-twitter"></i>
        </div>
        <p class="card-category">Ownership</p>
        <h3 class="card-title">{{ $count_bp['too'] }}</h3>
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="material-icons">update</i> Transfer of Ownership
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header card-header-success card-header-icon">
        <div class="card-icon">
          <i class="material-icons"></i>
        </div>
        <h4 class="card-title">Barangay Sales by Top Locations</h4>
      </div>
      <div class="card-body ">
        <div class="row">
          <div class="col-md-6">
            <div class="table-responsive table-sales">
              <table class="table">
                <tbody>
                  <tr>
                    <td style="width:50%">Adya</td>
                    <td style="width:25%" class="text-right">
                      2.920
                    </td>
                    <td style="width:25%" class="text-right">
                      53.23%
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%">Anilao</td>
                    <td  style="width:25%" class="text-right">
                      1.300
                    </td>
                    <td  style="width:25%"class="text-right">
                      20.43%
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%">Anilao-Labac</td>
                    <td  style="width:25%" class="text-right">
                      1.300
                    </td>
                    <td  style="width:25%"class="text-right">
                      20.43%
                    </td>
                  </tr>
                  <tr>
                    
                    <td style="width:50%">Antipolo Del Norte</td>
                    <td  style="width:25%" class="text-right">
                      1.300
                    </td>
                    <td  style="width:25%"class="text-right">
                      20.43%
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%">Antipolo Del Sur</td>
                    <td  style="width:25%" class="text-right">
                      1.300
                    </td>
                    <td  style="width:25%"class="text-right">
                      20.43%
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%">Bagong Pook</td>
                    <td  style="width:25%" class="text-right">
                      1.300
                    </td>
                    <td  style="width:25%"class="text-right">
                      20.43%
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%">Balintawak</td>
                    <td  style="width:25%" class="text-right">
                      1.300
                    </td>
                    <td  style="width:25%"class="text-right">
                      20.43%
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%">Banaybanay</td>
                    <td  style="width:25%" class="text-right">
                      1.300
                    </td>
                    <td  style="width:25%"class="text-right">
                      20.43%
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-6 ml-auto mr-auto">
            <div id="worldMap" style="height: 300px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
      

    <div class="row">
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-rose" data-header-animation="true">
              <div class="ct-chart" id="websiteViewsChart"></div>
            </div>
            <div class="card-body">
              <div class="card-actions">
                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                  <i class="material-icons">build</i> Fix Header!
                </button>
                <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                  <i class="material-icons">refresh</i>
                </button>
                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                  <i class="material-icons">edit</i>
                </button>
              </div>
              <h4 class="card-title">Website Views</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-success" data-header-animation="true">
              <div class="ct-chart" id="dailySalesChart"></div>
            </div>
            <div class="card-body">
              <div class="card-actions">
                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                  <i class="material-icons">build</i> Fix Header!
                </button>
                <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                  <i class="material-icons">refresh</i>
                </button>
                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                  <i class="material-icons">edit</i>
                </button>
              </div>
              <h4 class="card-title">Daily Sales</h4>
              <p class="card-category">
                <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> updated 4 minutes ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-info" data-header-animation="true">
              <div class="ct-chart" id="completedTasksChart"></div>
            </div>
            <div class="card-body">
              <div class="card-actions">
                <button type="button" class="btn btn-danger btn-link fix-broken-card">
                  <i class="material-icons">build</i> Fix Header!
                </button>
                <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
                  <i class="material-icons">refresh</i>
                </button>
                <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
                  <i class="material-icons">edit</i>
                </button>
              </div>
              <h4 class="card-title">Completed Tasks</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>
      </div>
      
@endsection


@section('scripts')
    <script>
        $('.alert').alert();
        
    </script>
    
    @if (Session::has('status'))
      <script>
        $(document).ready(e => {
          setTimeout(function () {
            md.showNotification('bottom', 'right', '{{Session::get('status')}}');
          }, 2000)
        });
      </script>
    @endif
@endsection
