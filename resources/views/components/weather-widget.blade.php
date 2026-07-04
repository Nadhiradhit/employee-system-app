{{-- Weather Widget — fetches current weather via AJAX --}}
<div class="card bg-base-100 border border-base-content/5" id="weather-widget">
    <div class="card-body">
        <h2 class="card-title gap-2">
            <span class="material-symbols-outlined text-primary">cloud</span>
            Current Weather
        </h2>

        {{-- Coordinate Input Form --}}
        <form id="weather-form" class="flex flex-wrap items-end gap-3 mt-2">
            <div class="form-control w-32">
                <label class="label py-0.5">
                    <span class="label-text text-xs">Latitude</span>
                </label>
                <input type="number" step="any" name="lat" id="weather-lat"
                    class="input input-bordered input-sm w-full" placeholder="-6.2" min="-90" max="90"
                    required>
            </div>
            <div class="form-control w-32">
                <label class="label py-0.5">
                    <span class="label-text text-xs">Longitude</span>
                </label>
                <input type="number" step="any" name="lon" id="weather-lon"
                    class="input input-bordered input-sm w-full" placeholder="106.8" min="-180" max="180"
                    required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm gap-1" id="weather-submit">
                <span class="material-symbols-outlined text-base">search</span>
                Fetch
            </button>
        </form>

        {{-- Loading State --}}
        <div id="weather-loading" class="hidden flex items-center gap-2 mt-4">
            <span class="loading loading-spinner loading-sm text-primary"></span>
            <span class="text-sm opacity-60">Fetching weather data…</span>
        </div>

        {{-- Error State --}}
        <div id="weather-error" class="hidden mt-4">
            <div class="alert alert-error alert-sm">
                <span class="material-symbols-outlined text-base">error</span>
                <span id="weather-error-message">Something went wrong.</span>
            </div>
        </div>

        {{-- Weather Data Display --}}
        <div id="weather-data" class="hidden mt-4">
            <div class="flex items-center gap-4 mb-3">
                <img id="weather-icon" src="" alt="Weather icon" class="w-16 h-16">
                <div>
                    <p class="text-3xl font-bold"><span id="weather-temp">--</span>°C</p>
                    <p class="text-sm opacity-70 capitalize" id="weather-description">--</p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="stat bg-base-200/50 rounded-box p-3">
                    <div class="stat-title text-xs">Feels Like</div>
                    <div class="stat-value text-lg"><span id="weather-feels">--</span>°C</div>
                </div>
                <div class="stat bg-base-200/50 rounded-box p-3">
                    <div class="stat-title text-xs">Humidity</div>
                    <div class="stat-value text-lg"><span id="weather-humidity">--</span>%</div>
                </div>
                <div class="stat bg-base-200/50 rounded-box p-3">
                    <div class="stat-title text-xs">Wind Speed</div>
                    <div class="stat-value text-lg"><span id="weather-wind">--</span> m/s</div>
                </div>
                <div class="stat bg-base-200/50 rounded-box p-3">
                    <div class="stat-title text-xs">Pressure</div>
                    <div class="stat-value text-lg"><span id="weather-pressure">--</span> hPa</div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-3">
                <div class="stat bg-base-200/50 rounded-box p-3">
                    <div class="stat-title text-xs">Clouds</div>
                    <div class="stat-value text-lg"><span id="weather-clouds">--</span>%</div>
                </div>
                <div class="stat bg-base-200/50 rounded-box p-3">
                    <div class="stat-title text-xs">UV Index</div>
                    <div class="stat-value text-lg" id="weather-uvi">--</div>
                </div>
                <div class="stat bg-base-200/50 rounded-box p-3">
                    <div class="stat-title text-xs">Visibility</div>
                    <div class="stat-value text-lg"><span id="weather-visibility">--</span> km</div>
                </div>
                <div class="stat bg-base-200/50 rounded-box p-3">
                    <div class="stat-title text-xs">Condition</div>
                    <div class="stat-value text-lg" id="weather-condition">--</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('weather-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const lat = document.getElementById('weather-lat').value;
        const lon = document.getElementById('weather-lon').value;


        document.getElementById('weather-loading').classList.remove('hidden');
        document.getElementById('weather-data').classList.add('hidden');
        document.getElementById('weather-error').classList.add('hidden');
        document.getElementById('weather-submit').setAttribute('disabled', 'true');

        try {
            const response = await fetch(
                `{{ route('weather.show') }}?lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

            const json = await response.json();

            if (!response.ok || !json.status) {
                throw new Error(json.message || 'Failed to fetch weather data.');
            }

            const d = json.data;


            document.getElementById('weather-temp').textContent = d.temp ?? '--';
            document.getElementById('weather-feels').textContent = d.feels_like ?? '--';
            document.getElementById('weather-description').textContent = d.description ?? '--';
            document.getElementById('weather-humidity').textContent = d.humidity ?? '--';
            document.getElementById('weather-wind').textContent = d.wind_speed ?? '--';
            document.getElementById('weather-pressure').textContent = d.pressure ?? '--';
            document.getElementById('weather-clouds').textContent = d.clouds ?? '--';
            document.getElementById('weather-uvi').textContent = d.uvi ?? '--';
            document.getElementById('weather-visibility').textContent = d.visibility ? (d.visibility / 1000)
                .toFixed(1) : '--';
            document.getElementById('weather-condition').textContent = d.condition ?? '--';


            if (d.icon) {
                document.getElementById('weather-icon').src =
                    `https://openweathermap.org/img/wn/${d.icon}@2x.png`;
                document.getElementById('weather-icon').classList.remove('hidden');
            } else {
                document.getElementById('weather-icon').classList.add('hidden');
            }

            document.getElementById('weather-data').classList.remove('hidden');
        } catch (err) {
            document.getElementById('weather-error-message').textContent = err.message;
            document.getElementById('weather-error').classList.remove('hidden');
        } finally {
            document.getElementById('weather-loading').classList.add('hidden');
            document.getElementById('weather-submit').removeAttribute('disabled');
        }
    });
</script>
