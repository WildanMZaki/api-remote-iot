@extends('layouts.master')

@section('title', 'My Remote')

@push('styles')
<style>

/* Gauge */
.gauge {
  width: 50%;
  max-width: 250px;
  font-size:25px;
  font-weight:bold;
  font-family:sans-serif;
  color: #060814;
}

.gauge__body {
  width: 100%;
  height: 0;
  padding-bottom: 50%;
  background: #b4c0be;
  position: relative;
  border-top-left-radius: 100% 200%;
  border-top-right-radius: 100% 200%;
  overflow: hidden;
}

.gauge__fill {
  position: absolute;
  top: 100%;
  left: 0;
  width: inherit;
  height: 100%;
  background: #009578;
  transform-origin: center top;
  transform: rotate(0.25turn);
  transition: transform 0.2s ease-out;
}

.gauge__cover {
  width: 90%;
  height: 180%;
  background: #ffffff;
  border-radius: 50%;
  position: absolute;
  top: 10%;
  left: 50%;
  transform: translateX(-50%);

  /* Text */
  display: flex;
  align-items: center;
  justify-content: center;
  padding-bottom: 25%;
  box-sizing: border-box;
}    


/* Medium screens (768px - 991px) */
@media screen and (min-width: 768px) and (max-width: 991px) {
  .gauge {
    width: 75%;
  }
}

/* Small screens (< 768px) */
@media screen and (max-width: 767px) {
  .gauge {
    width: 100%;
  }
}
</style>
<link rel="stylesheet" href="{{asset('css/components/pie.css')}}">
<link rel="stylesheet" href="{{asset('css/components/togle.css')}}">
@endpush

@section('content')
    <main class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 d-flex flex-column flex-lg-row p-lg-5 p-2 gap-lg-4 gap-3">
                <section id="sensor" class="w-100 m-lg-3 rounded-4 my-3 d-flex flex-lg-column flex-row gap-2">
                    <div class="sensor-item rounded-3 shadow p-3 border-info border d-flex flex-column align-items-center w-100">
                        <h2>Suhu:</h2>
                        <div class="gauge">
                        <div class="gauge__body">
                            <div class="gauge__fill" id="tempChart"></div>
                            <div class="gauge__cover" id="tempValue"></div>
                        </div>
                        </div>
                    </div>
                    <div class="sensor-item rounded-3 shadow p-3 border-info border d-flex flex-column align-items-center w-100">
                        <h2>Kelembaban:</h2>
                        <div id="humi" class="pie" style="--p:{{$dht->humidity}};--c:rgb(29, 78, 236);--b:7px">{{$dht->humidity}} %</div>
                    </div>
                </section>

                <section id="control" class="border border-info w-100 m-lg-3 rounded-4 relative">
                  <div id="toggles" class="d-flex justify-content-around py-3">
                    @foreach ($pins as $pin)    
                      <label class="toggle border shadow p-3 rounded-3" for="{{$pin->pin}}">
                        <input type="checkbox" class="toggle__input" id="{{$pin->pin}}" {{(($pin->state) ? "checked" : '')}} data-url="{{route('pin.update', $pin->pin).'?key='.env('API_KEY', `@p1|<ey123`)}}" />
                        <span class="toggle-track">
                          <span class="toggle-indicator">
                            <!--  This check mark is optional  -->
                            <span class="checkMark">
                              <svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
                                <path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
                              </svg>
                            </span>
                          </span>
                        </span>
                        <span class="pinDevice" id="{{$pin->pin}}Device">{{$pin->device}}</span>
                      </label>
                    @endforeach
                  </div>

                  {{-- <button class="btn btn-secondary" id="settingBtn">
                    Se
                  </button> --}}
                </section>
            </div>
        </div>
    </main>
    <span id="dht" class="d-none" data-temp="{{$dht->temperature}}"></span>
    <span id="monitor" class="d-none" data-url="{{route('monitor').'?key='.env('API_KEY', '@p1|<ey123')}}"></span>
@endsection

@push('scripts')
<script>
const gaugeElement = document.querySelector(".gauge");

function setTemperature(value) {
  let temp = value;
  if (value < 0) value = 0;
  if (value > 40) value = 40;
  document.querySelector("#tempChart").style.transform = `rotate(${
    fill(value)
  }turn)`;
  document.querySelector("#tempChart").style.background = fillColor(value);
  document.querySelector("#tempValue").textContent = `${temp}\u00B0C`;
}

const fill = value => value / 200 * 2.5;
const fillColor = value => {
  if (value < 0) return '#0850eb';
  else if (value >= 0 && value <= 10) return '#0885eb';
  else if (value > 10 && value <= 20) return '#08eba7';
  else if (value > 20 && value <= 30) return '#94eb08';
  else if (value > 30 && value <= 40) return '#ffae00';
  else if (value > 40) return '#ff0000';
}

function setHumidity(humi) {
  if (humi < 0) humi = 0;
  if (humi > 100) humi = 100;
  $('#humi').get(0).style.setProperty('--p', humi);
  $('#humi').html(humi+' %');
}

setTemperature($('#dht').data('temp'));

$('#toggles').on('change', '.toggle', (e) => {
    const checkbox = $(`#${e.currentTarget.htmlFor}`).get(0);
    const { url } = checkbox.dataset;
    const state = checkbox.checked ? 1 : 0;
    // Perform an AJAX GET request
    $.ajax({
      url: url+'&method=web',
      method: 'PUT',
      dataType: 'json', // Response data type (JSON in this example)
      data: {
        state: state,
      },
      success: function (data) {
        // Handle the successful response here
        console.log('Data received:', data);
      },
      error: function (xhr, status, error) {
        // Handle any errors here
        console.error('Error:', error);
      }
    });
});

const monitorUrl = $('#monitor').data('url');

const monitor = () => {
  $.ajax({
    url: monitorUrl,
    method: 'GET',
    dataType: 'json',
    success: function ({dht, pins}) {
      
      // Handle the successful response here
      setTemperature(dht.temperature);
      setHumidity(dht.humidity);
      pins.forEach(pin => {
        const {state, device} = pin;
        $(`#${pin.pin}`).get(0).checked = state;
        $(`#${pin.pin}Device`).html(device);
      });
      setTimeout(() => {
        monitor();
      }, 10000);
    },
    error: function (xhr, status, error) {
      // Handle any errors here
      console.error('Error:', error);
    }
  });
}
setTimeout(() => {
  monitor();
}, 10000);
</script>
@endpush