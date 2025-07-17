// SIDEBAR DROPDOWN
const allDropdown = document.querySelectorAll('#sidebar .side-dropdown');
const sidebar = document.getElementById('sidebar');

allDropdown.forEach(item=> {
	const a = item.parentElement.querySelector('a:first-child');
	a.addEventListener('click', function (e) {
		e.preventDefault();

		if(!this.classList.contains('active')) {
			allDropdown.forEach(i=> {
				const aLink = i.parentElement.querySelector('a:first-child');

				aLink.classList.remove('active');
				i.classList.remove('show');
			})
		}

		this.classList.toggle('active');
		item.classList.toggle('show');
	})
})





// SIDEBAR COLLAPSE
const toggleSidebar = document.querySelector('nav .toggle-sidebar');
const allSideDivider = document.querySelectorAll('#sidebar .divider');

if(sidebar.classList.contains('hide')) {
	allSideDivider.forEach(item=> {
		item.textContent = '-'
	})
	allDropdown.forEach(item=> {
		const a = item.parentElement.querySelector('a:first-child');
		a.classList.remove('active');
		item.classList.remove('show');
	})
} else {
	allSideDivider.forEach(item=> {
		item.textContent = item.dataset.text;
	})
}

toggleSidebar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');

	if(sidebar.classList.contains('hide')) {
		allSideDivider.forEach(item=> {
			item.textContent = '-'
		})

		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
	} else {
		allSideDivider.forEach(item=> {
			item.textContent = item.dataset.text;
		})
	}
})




sidebar.addEventListener('mouseleave', function () {
	if(this.classList.contains('hide')) {
		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
		allSideDivider.forEach(item=> {
			item.textContent = '-'
		})
	}
})



sidebar.addEventListener('mouseenter', function () {
	if(this.classList.contains('hide')) {
		allDropdown.forEach(item=> {
			const a = item.parentElement.querySelector('a:first-child');
			a.classList.remove('active');
			item.classList.remove('show');
		})
		allSideDivider.forEach(item=> {
			item.textContent = item.dataset.text;
		})
	}
})




// PROFILE DROPDOWN
const profile = document.querySelector('nav .profile');
const imgProfile = profile.querySelector('img');
const dropdownProfile = profile.querySelector('.profile-link');

imgProfile.addEventListener('click', function () {
	dropdownProfile.classList.toggle('show');
})




// MENU
const allMenu = document.querySelectorAll('main .content-data .head .menu');

allMenu.forEach(item=> {
	const icon = item.querySelector('.icon');
	const menuLink = item.querySelector('.menu-link');

	icon.addEventListener('click', function () {
		menuLink.classList.toggle('show');
	})
})



window.addEventListener('click', function (e) {
	if(e.target !== imgProfile) {
		if(e.target !== dropdownProfile) {
			if(dropdownProfile.classList.contains('show')) {
				dropdownProfile.classList.remove('show');
			}
		}
	}

	allMenu.forEach(item=> {
		const icon = item.querySelector('.icon');
		const menuLink = item.querySelector('.menu-link');

		if(e.target !== icon) {
			if(e.target !== menuLink) {
				if (menuLink.classList.contains('show')) {
					menuLink.classList.remove('show')
				}
			}
		}
	})
})





// PROGRESSBAR
const allProgress = document.querySelectorAll('main .card .progress');

allProgress.forEach(item=> {
	item.style.setProperty('--value', item.dataset.value)
})






// APEXCHART


      
var options = {
	series: [{
	  name: "Attendance",
	  data: [1, 65, 55, 80, 65, 36, 32, 63, 74, 50, 35, 1]
  }],
	chart: {
	height: 350,
	type: 'area',
	zoom: {
	  enabled: false
	}
  },
  dataLabels: {
	enabled: false
  },
  stroke: {
	curve: 'straight'
  },
  title: {
	text: 'Monthly events attendance (2022)',
	align: 'centre'
  },
  grid: {
	row: {
	  colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
	  opacity: 0.5
	},
  },
  xaxis: {
	categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
	title: {
	  text: 'Month'
	}
  },
  yaxis: {
	axisBorder: {
	  show: false
	},
	axisTicks: {
	  show: false,
	},
	labels: {
	  show: true,
	  formatter: function (val) {
		return val + "%";
	  }
	},
	title: {
	  text: 'Attendance percentage'
	}
  
  }
  };

  var chart = new ApexCharts(document.querySelector("#chart1"), options);
  chart.render();

// var options = {
// 	series: [{
// 	name: 'Participation',
// 	data: [50, 65, 55, 80, 65, 36, 32, 63, 74, 50, 35, 82]
//   }],
// 	chart: {
// 	height: 350,
// 	type: 'bar',
//   },
//   plotOptions: {
// 	bar: {
// 	  borderRadius: 10,
// 	  dataLabels: {
// 		position: 'top', // top, center, bottom
// 	  },
// 	}
//   },
//   dataLabels: {
// 	enabled: true,
// 	formatter: function (val) {
// 	  return val + "%";
// 	},
// 	offsetY: -20,
// 	style: {
// 	  fontSize: '12px',
// 	  colors: ["#304758"]
// 	}
//   },
  
//   xaxis: {
// 	categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
// 	position: 'top',
// 	axisBorder: {
// 	  show: false
// 	},
// 	axisTicks: {
// 	  show: false
// 	},
// 	crosshairs: {
// 	  fill: {
// 		type: 'gradient',
// 		gradient: {
// 		  colorFrom: '#D8E3F0',
// 		  colorTo: '#BED1E6',
// 		  stops: [0, 100],
// 		  opacityFrom: 0.4,
// 		  opacityTo: 0.5,
// 		}
// 	  }
// 	},
// 	tooltip: {
// 	  enabled: true,
// 	}
//   },
//   yaxis: {
// 	axisBorder: {
// 	  show: false
// 	},
// 	axisTicks: {
// 	  show: false,
// 	},
// 	labels: {
// 	  show: false,
// 	  formatter: function (val) {
// 		return val + "%";
// 	  }
// 	}
  
//   },
//   title: {
// 	text: 'Monthly events attendance, 2022',
// 	floating: true,
// 	offsetY: 330,
// 	align: 'center',
// 	style: {
// 	  color: '#444'
// 	}
//   }
//   };

//   var chart = new ApexCharts(document.querySelector("#chart1"), options);
//   chart.render();

  
      
//   var options2 = {
// 	series: [{
// 	name: 'Number of new volunteers',
// 	data: [31, 40, 28, 44, 42, 29, 38, 31, 40, 28, 41, 42]
//   }],
// 	chart: {
// 	height: 350,
// 	type: 'area'
//   },
//   dataLabels: {
// 	enabled: false
//   },
//   stroke: {
// 	curve: 'smooth'
//   },
//   xaxis: {
// 	categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
// 	title: {
// 	  text: 'Months'
// 	}
//   },
//   tooltip: {
// 	x: {
// 	  format: 'dd/MM/yy HH:mm'
// 	},
//   },
//   title: {
// 	text: 'Monthly new volunteers',
// 	align: 'centre'
//   },
//   yaxis: {
// 	title: {
// 	  text: 'Number of new volunteers'
// 	}
  
//   }
//   };

  var options2 = {
	series: [{
	name: 'Male',
	data: [44, 55, 41, 67, 22, 43, 11, 17, 15, 15, 21, 14]
  }, {
	name: 'Female',
	data: [13, 26, 20, 8, 13, 27, 21, 7, 25, 13, 22, 8]
  }],
  title: {
	text: 'Monthly new volunteers  (2022)',
	align: 'centre'
  },
	chart: {
	type: 'bar',
	height: 350,
	stacked: true,
	toolbar: {
	  show: true
	},
	zoom: {
	  enabled: true
	}
  },
  responsive: [{
	breakpoint: 480,
	options: {
	  legend: {
		position: 'bottom',
		offsetX: -10,
		offsetY: 0
	  }
	}
  }],
  plotOptions: {
	bar: {
	  horizontal: false,
	  borderRadius: 10,
	  dataLabels: {
		total: {
		  enabled: true,
		  style: {
			fontSize: '13px',
			fontWeight: 900
		  }
		}
	  }
	},
  },
  xaxis: {
	categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
	title: {
	  text: 'Months'
	}
  },
  legend: {
	position: 'right',
	offsetY: 40
  },
  fill: {
	opacity: 1
  },
  yaxis: {
	title: {
	  text: 'Number of new volunteers (Male/Female)'
	}
},
colors: ['#8bbaf8', '#F7BEC0']
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();

  var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
  chart2.render();  

      
  var options3 = {
	series: [{
	name: 'Number of hours engaged',
	data: [330, 420, 300]
  }],
	chart: {
	height: 350,
	type: 'bar',
  },
  plotOptions: {
	bar: {
	  borderRadius: 10,
	  dataLabels: {
		position: 'top', // top, center, bottom
	  },
	}
  },
  dataLabels: {
	enabled: true,
	formatter: function (val) {
	  return val;
	},
	offsetY: -20,
	style: {
	  fontSize: '12px',
	  colors: ["#304758"]
	}
  },
  
  xaxis: {
	categories: ["James", "David", "Woody"],
	crosshairs: {
	  fill: {
		type: 'gradient',
		gradient: {
		  colorFrom: '#D8E3F0',
		  colorTo: '#BED1E6',
		  stops: [0, 100],
		  opacityFrom: 0.4,
		  opacityTo: 0.5,
		}
	  }
	},
	tooltip: {
	  enabled: true,
	},
	title: {
	  text: 'Top volunteers'
	}
  },
  yaxis: {
	labels: {
	  show: true,
	  formatter: function (val) {
		return val;
	  }
	},
	title: {
	  text: 'Number of hours engaged'
	},
  },
  title: {
	text: 'Volunteer of the Year (2023)',
	align: 'centre'
  }
  };

  var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
  chart3.render();
  

  var options4 = {
	series: [10, 40, 20],
	colors: ['#8bbaf8', '#1775F1', '#0b3a78'],
	chart: {
	height: 380,
	type: 'pie',
  },
  title: {
	text: 'Type of activity (2022)',
	align: 'centre'
  },
  labels: ['Project', 'Event', 'Other'],
  responsive: [{
	breakpoint: 480,
	options: {
	  chart: {
		width: 'auto'
	  },
	  legend: {
		position: 'bottom'
	  }
	}
  }]
  };

  var chart4 = new ApexCharts(document.querySelector("#chart4"), options4);
  chart4.render();
      
  var engagement = {
	series: [
	{
	  name: 'box',
	  type: 'boxPlot',
	  data: [
		{
		  x: 'Jan',
		  y: [3, 10, 15, 20, 27]
		},
		{
		  x: "Feb",
		  y: [5, 12, 17, 22, 28]
		},
		{
		  x: "Mar",
		  y: [4, 14, 18, 23, 29]
		},
		{
		  x: "Apr",
		  y: [7, 10, 14, 21, 25]
		},
		{
		  x: "May",
		  y: [3, 13, 16, 22, 27]
		},
		{
		  x: "Jun",
		  y: [5, 16, 19, 25, 29]
		},
		{
		  x: 'Jul',
		  y: [3, 10, 15, 20, 27]
		},
		{
		  x: "Aug",
		  y: [5, 12, 17, 22, 28]
		},
		{
		  x: "Sep",
		  y: [4, 14, 18, 23, 29]
		},
		{
		  x: "Oct",
		  y: [7, 10, 14, 21, 25]
		},
		{
		  x: "Nov",
		  y: [3, 13, 16, 22, 27]
		},
		{
		  x: "Dec",
		  y: [5, 16, 19, 25, 29]
		}
	  ]
	}
	,{
	  name: 'outliers',
	  type: 'scatter',
	  data: [
		{
		  x: "Jan",
		  y: 40
		},
		{
		  x: "Feb",
		  y: 38
		},
		{
		  x: "Mar",
		  y: 42
		},
		{
		  x: "Apr",
		  y: 37
		},
		{
		  x: "May",
		  y: 45
		},
		{
		  x: "Jun",
		  y: 42
		},
		{
		  x: "Jul",
		  y: 40
		},
		{
		  x: "Aug",
		  y: 38
		},
		{
		  x: "Sep",
		  y: 42
		},
		{
		  x: "Oct",
		  y: 37
		},
		{
		  x: "Nov",
		  y: 45
		},
		{
		  x: "Dec",
		  y: 42
		}
	  ]
	}
  ],
	chart: {
	type: 'boxPlot',
	height: 350
  },
  title: {
	text: 'Monthly volunteer engagement (2022)',
	align: 'centre'
  },
  xaxis: {
	title: {
	  text: 'Month'
	}
  },
  yaxis: {
	title: {
	  text: 'Engagement in hour'
	}
},

  tooltip: {
	shared: false,
	intersect: true
  },
  plotOptions: {
	boxPlot: {
	  colors: {
		upper: '#0b3a78',
		lower: '#1775F1'
	  }
	}
  },
  colors: ['#0b3a78', '#8bbaf8'],
  };

  var engagement_report = new ApexCharts(document.querySelector("#engagement_report"), engagement);
  engagement_report.render();


  var volunteer_age_report_options = {
	series: [{
	name: 'Males',
	// data: [0.88, 1.5, 2.1, 2.9, 3.8, 3.9, 4.2, 4, 4.3, 4.1, 4.2, 4.5,
	//   3.9, 3.5, 3
	// ]
	data: [
		2, 5, 15, 25, 
		27, 30, 25, 10,
		8, 6, 5, 4,
		3, 2
	]
  },
  {
	name: 'Females',
	// data: [-1.18, -1.4, -2.2, -2.85, -3.7, -3.96, -4.22, -4.3, -4.4,
	//   -4.1, -4, -4.1, -3.4, -3.1, -2.8
	// ]
	data: [
		-2, -5, -15, -25, 
		-27, -30, -25, -10,
		-8, -6, -5, -4,
		-3, -2
	]
  }
  ],
	chart: {
	type: 'bar',
	height: 350,
	stacked: true
  },
  colors: ['#1775F1', '#F7BEC0'],
  plotOptions: {
	bar: {
	  horizontal: true,
	  barHeight: '80%',
	},
  },
  dataLabels: {
	enabled: false
  },
  stroke: {
	width: 1,
	colors: ["#fff"]
  },
  
  grid: {
	xaxis: {
	  lines: {
		show: false
	  }
	}
  },
  yaxis: {
	min: -40,
	max: 40,
	title: {
	  text: 'Age group',
	},
  },
  tooltip: {
	shared: false,
	x: {
	  formatter: function (val) {
		return val
	  }
	},
	y: {
	  formatter: function (val) {
		return Math.abs(val) + "%"
	  }
	}
  },
  title: {
	text: 'Volunteer age (2022)',
	align: 'centre'
  },
  xaxis: {
	categories: ['75+', '70-74', '65-69', '60-64', 
	'55-59', '50-54', '45-49', '40-44', 
	'35-39', '30-34', '25-29', '20-24', 
	'15-19', '10-14', '0-9'
	],
	title: {
	  text: 'Volunteer age percent (Male/Female)'
	},
	labels: {
	  formatter: function (val) {
		return Math.abs(Math.round(val)) + "%"
	  }
	}
  },
  };

  var volunteer_age_report = new ApexCharts(document.querySelector("#volunteer_age_report"), volunteer_age_report_options);
  volunteer_age_report.render();
