// APEXCHART
/* var attendance_report_options = {
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

    var attendance_report = new ApexCharts(document.querySelector("#attendance_report"), attendance_report_options);
    attendance_report.render();
 
 */
    
  var new_volunteer_report_options = {
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

  var new_volunteer_report = new ApexCharts(document.querySelector("#new_volunteer_report"), new_volunteer_report_options);
  new_volunteer_report.render();  


  

      
  var top_volunteer_report_options = {
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

  var top_volunteer_report = new ApexCharts(document.querySelector("#top_volunteer_report"), top_volunteer_report_options);
  top_volunteer_report.render();
  
/*   
var activity_type_report_options = {
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

  var activity_type_report = new ApexCharts(document.querySelector("#activity_type_report"), activity_type_report_options);
  activity_type_report.render();
 */
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