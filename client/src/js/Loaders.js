const loaders = {
  loader_type: {
    circular: `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' preserveAspectRatio='xMidYMid'>
      <circle cx='50' cy='50' r='45' fill='none' stroke='#000' stroke-width='8'/>
      <circle cx='50' cy='50' r='45' fill='none' stroke='#fff' stroke-width='8' stroke-dasharray='283.49' stroke-dashoffset='141.75'>
        <animate attributeName='stroke-dashoffset' dur='2s' repeatCount='indefinite' keyTimes='0;1' values='0;283.49'/>
      </circle>
    </svg>`,
    spinner: `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 50 50'>
      <circle cx='25' cy='25' r='20' fill='none' stroke-width='5' stroke='#000' stroke-dasharray='31.415, 31.415' transform='rotate(108 25 25)'>
        <animateTransform attributeName='transform' type='rotate' repeatCount='indefinite' dur='1s' values='0 25 25;360 25 25'/>
      </circle>
    </svg>`,
    bar: `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' preserveAspectRatio='xMidYMid'>
      <rect x='10' y='30' width='15' height='40' fill='#000'>
        <animate attributeName='height' dur='1s' repeatCount='indefinite' keyTimes='0;0.5;1' values='40;60;40'/>
      </rect>
      <rect x='35' y='30' width='15' height='40' fill='#000'>
        <animate attributeName='height' dur='1s' repeatCount='indefinite' keyTimes='0;0.5;1' values='40;80;40'/>
      </rect>
      <rect x='60' y='30' width='15' height='40' fill='#000'>
        <animate attributeName='height' dur='1s' repeatCount='indefinite' keyTimes='0;0.5;1' values='40;70;40'/>
      </rect>
      <rect x='85' y='30' width='15' height='40' fill='#000'>
        <animate attributeName='height' dur='1s' repeatCount='indefinite' keyTimes='0;0.5;1' values='40;90;40'/>
      </rect>
    </svg>`,
    pulse: `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' preserveAspectRatio='xMidYMid'>
      <circle cx='50' cy='50' r='30' fill='none' stroke-width='8' stroke='#000'>
        <animate attributeName='r' dur='2s' repeatCount='indefinite' keyTimes='0;1' values='0;30'/>
        <animate attributeName='opacity' dur='2s' repeatCount='indefinite' keyTimes='0;1' values='1;0'/>
      </circle>
    </svg>`
  },
  show: function (load_div, type, message = "") {
    // Use the loader type
    const loader = this.loader_type[type];
    const toEdit = document.getElementById(load_div);
    toEdit.style.display = 'block';
    toEdit.innerHTML = loader;
  },
  hide: function (load_div, type, message = "") {
    document.getElementById(load_div).style.display = 'none';
  }
}
