@props(['minRange', 'maxRange', 'idRange'])
<div x-data="rangeAttr{{ $idRange }}" @reset-range.window="reset()">

  <div class="flex flex-col items-center w-full max-w-xl px-2">
    <input class="absolute opacity-0 pointer-events-none" type="range" name="min" min="10" max="100" :value="min">
    <input class="absolute opacity-0 pointer-events-none" type="range" name="max" min="10" max="100" :value="max">

    <div class="flex items-center justify-between w-full">
      <div class="-ml-2" x-text=" min">
      </div>
      <div class="-mr-2" x-text=" max">
      </div>
    </div>

    <div class="relative flex items-center w-full h-1 mt-4 bg-gray-200 rounded" x-ref="sliderEl"
      @mouseup.window="dragLeft = dragRight = false" @mousemove.window="handleThumbMouseMove($event)"
      style="user-select: none">
      <div class="absolute h-1 bg-yellow-300"
        :style="`left: ${(min - rangeMin) * 100 / range}%; right: ${100 - (max - rangeMin) * 100 / range}%`"></div>
      <div class="absolute w-5 h-5 -ml-2 bg-yellow-400 rounded-full cursor-pointer" @mousedown="dragLeft = true"
        @mouseup="$wire.emit('updateMinRange', min, {{ $idRange }})"
        :style="`left: ${(min - rangeMin) * 100 / range}%`" x-ref="minThumb">
      </div>
      <div class="absolute w-5 h-5 -ml-2 bg-yellow-400 rounded-full cursor-pointer" @mousedown="dragRight = true"
        @mouseup="$wire.emit('updateMaxRange', max, {{ $idRange }})"
        :style="`left: ${(max - rangeMin) * 100 / range}%`" x-ref="maxThumb">
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('alpine:initializing', () => {
      Alpine.data('rangeAttr{{ $idRange }}', () => ({
        range: {{ $maxRange }} - {{ $minRange }},
        rangeMin: {{ $minRange }},
        rangeMax: {{ $maxRange }},
        min: {{ $minRange }},
        max: {{ $maxRange }},
        dragLeft: false,
        dragRight: false,
        reset() {
          this.range = {{ $maxRange }} - {{ $minRange }};
          this.min = {{ $minRange }};
          this.max = {{ $maxRange }};
          this.rangeMin = {{ $minRange }};
          this.rangeMax = {{ $maxRange }};
        },
        handleThumbMouseMove: function(e) {
          if (!this.dragLeft && !this.dragRight) return;

          const thumbEl = this.dragLeft ? this.$refs.minThumb : this.$refs.maxThumb;

          const sliderRect = this.$refs.sliderEl.getBoundingClientRect();

          let r = (e.clientX - sliderRect.left) / sliderRect.width;
          r = Math.max(0, Math.min(r, 1));
          const value = Math.floor(r * this.range + this.rangeMin);

          if (this.dragLeft) {
            this.min = value;
            this.max = Math.max(this.min, this.max);
          } else {
            this.max = value;
            this.min = Math.min(this.min, this.max);
          }
        }
      }))
    })
  </script>

</div>
