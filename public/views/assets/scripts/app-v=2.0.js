var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon"),
    themeToggleLightIcon = document.getElementById("theme-toggle-light-icon"),
    themeToggleBtn = document.getElementById("theme-toggle");

if (themeToggleBtn && themeToggleBtn !== null) {
    "dark" === localStorage.getItem("color-theme") || !("color-theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches ? (document.documentElement.classList.add("dark"), themeToggleBtn.checked = !1) : (document.documentElement.classList.remove("dark"), themeToggleBtn.checked = !0), [themeToggleDarkIcon, themeToggleLightIcon, themeToggleBtn].forEach((e => {
        e.addEventListener("click", (function (e) {
            return e.stopPropagation(), localStorage.getItem("color-theme") ? "light" === localStorage.getItem("color-theme") ? (document.documentElement.classList.add("dark"), localStorage.setItem("color-theme", "dark"), void (themeToggleBtn.checked = !1)) : (document.documentElement.classList.remove("dark"), localStorage.setItem("color-theme", "light"), void (themeToggleBtn.checked = !0)) : document.documentElement.classList.contains("dark") ? (document.documentElement.classList.remove("dark"), void localStorage.setItem("color-theme", "light")) : (document.documentElement.classList.add("dark"), void localStorage.setItem("color-theme", "dark"))
        }))
    }));
}

let sideBarBtn = document.getElementById("sidebar-btn"), sideBarExpandBtn = document.getElementById("sidebar-expand"),
    layout = document.getElementById("layout");

function toggleFullScreen() {
    var e = window.document, t = e.documentElement,
        l = t.requestFullscreen || t.mozRequestFullScreen || t.webkitRequestFullScreen || t.msRequestFullscreen,
        o = e.exitFullscreen || e.mozCancelFullScreen || e.webkitExitFullscreen || e.msExitFullscreen;
    e.fullscreenElement || e.mozFullScreenElement || e.webkitFullscreenElement || e.msFullscreenElement ? o.call(e) : l.call(t)
}

// sideBarBtn.addEventListener("click", (function (e) {
//     layout.classList.toggle("grid-cols-[257px,1fr]"), layout.classList.toggle("minimize"), sideBarBtn.classList.toggle("reverse")
// })), sideBarExpandBtn.addEventListener("click", toggleFullScreen);
const dropdownContent = document.querySelectorAll(".dropdown-label");

function checkAndCloseDropDown(e) {
    console.log("clicked"), console.log("e: ", e);
    let t = e.currentTarget;
    console.log("targetEl: ", t), t && t.matches(":focus") && setTimeout((function () {
        t.blur()
    }), 0)
}

dropdownContent && dropdownContent.forEach((e => {
    e.addEventListener("mousedown", (e => checkAndCloseDropDown(e)))
}));
const Utils = ChartUtils.init(), DATA_COUNT = 12, NUMBER_CFG = {count: 12, min: 0, max: 100},
    ctx = document.getElementById("performanceChart"), labels = Utils.months({count: 12}), data = {
        labels: labels,
        datasets: [{
            label: "Completed",
            data: Utils.numbers(NUMBER_CFG),
            backgroundColor: "#FC8D9D",
            fill: !0
        }, {label: "Pending", data: Utils.numbers(NUMBER_CFG), backgroundColor: "#F3BCFD", fill: !0}, {
            label: "Unpaid",
            data: Utils.numbers(NUMBER_CFG),
            backgroundColor: "#80B7FB",
            fill: !0
        }, {label: "Delivered", data: Utils.numbers(NUMBER_CFG), backgroundColor: "#B9A2FB", fill: !0}]
    }, config = {
        type: "line",
        data: data,
        options: {
            responsive: !0,
            plugins: {
                title: {display: !1},
                tooltip: {mode: "index"},
                legend: {
                    align: "start",
                    labels: {boxWidth: 16, boxHeight: 16, usePointStyle: !0, pointStyle: "rectRounded"}
                }
            },
            interaction: {mode: "nearest", axis: "x", intersect: !1},
            scales: {x: {title: {display: !1}}, y: {stacked: !1, display: !1, title: {display: !1}}}
        }
    };
if (ctx) {
    new Chart(ctx, config)
}
const ctxRevenue = document.getElementById("revenueChart"), dataRevenue = {
    labels: labels,
    datasets: [{
        label: "Direct",
        data: Utils.numbers(NUMBER_CFG),
        backgroundColor: "#5415F1",
        fill: !0
    }, {label: "Social", data: Utils.numbers(NUMBER_CFG), backgroundColor: "#DD50D6", fill: !0}]
}, configRevenue = {
    type: "line",
    data: dataRevenue,
    options: {
        responsive: !0,
        plugins: {
            title: {display: !1},
            tooltip: {mode: "index"},
            legend: {
                align: "start",
                labels: {boxWidth: 16, boxHeight: 16, usePointStyle: !0, pointStyle: "rectRounded"}
            }
        },
        interaction: {mode: "nearest", axis: "x", intersect: !1},
        scales: {x: {display: !1, title: {display: !1}}, y: {stacked: !1, display: !1, title: {display: !1}}}
    }
};
if (ctxRevenue) {
    new Chart(ctxRevenue, configRevenue)
}
const ctxVisit = document.getElementById("visitChart"), dataVisit = {
    labels: ["Direct", "Social", "Email", "Other"],
    datasets: [{
        label: "",
        data: [300, 50, 100, 150],
        backgroundColor: ["#FC8D9D", "#F3BCFD", "#80B7FB", "#B9A2FB"],
        hoverOffset: 4
    }]
}, configVisit = {
    type: "doughnut",
    data: dataVisit,
    options: {
        responsive: !0,
        plugins: {
            title: {display: !1},
            tooltip: {mode: "index"},
            legend: {
                align: "start",
                labels: {boxWidth: 16, boxHeight: 16, usePointStyle: !0, pointStyle: "rectRounded"}
            }
        }
    }
};
if (ctxVisit) {
    new Chart(ctxVisit, configVisit)
}
const ctxSeller = document.getElementById("sellerChart"), dataSeller = {
    labels: labels,
    datasets: [{
        label: "Order",
        data: Utils.numbers(NUMBER_CFG),
        borderColor: "#50D1B2",
        backgroundColor: "#50D1B2"
    }, {
        label: "Earnings",
        data: Utils.numbers(NUMBER_CFG),
        borderColor: "#EC8C56",
        backgroundColor: "#EC8C56"
    }, {label: "Refunds", data: Utils.numbers(NUMBER_CFG), borderColor: "#E23738", backgroundColor: "#E23738"}]
}, configSeller = {
    type: "line",
    data: dataSeller,
    options: {
        responsive: !0,
        plugins: {
            title: {display: !1},
            legend: {
                position: "bottom",
                align: "center",
                labels: {boxWidth: 8, boxHeight: 8, usePointStyle: !0, pointStyle: "circle"}
            }
        },
        elements: {line: {tension: .3}}
    }
};
if (ctxSeller) {
    new Chart(ctxSeller, configSeller)
}
const ctxIncome = document.getElementById("incomeChart"), dataIncome = {
    labels: labels,
    datasets: [{
        label: "Income",
        data: Utils.numbers(NUMBER_CFG),
        borderColor: "#50D1B2",
        backgroundColor: "#50D1B2",
        pointRadius: 0
    }]
}, configIncome = {
    type: "line",
    data: dataIncome,
    options: {
        responsive: !0,
        scales: {x: {display: !1}, y: {display: !1}},
        plugins: {title: {display: !1}, legend: {display: !1}},
        elements: {line: {tension: .5}}
    }
};
if (ctxIncome) {
    new Chart(ctxIncome, configIncome)
}
const ctxExpences = document.getElementById("expencesChart"), dataExpences = {
    labels: labels,
    datasets: [{
        label: "Expences",
        data: Utils.numbers(NUMBER_CFG),
        borderColor: "#E23738",
        backgroundColor: "#E23738",
        pointRadius: 0
    }]
}, configExpences = {
    type: "line",
    data: dataExpences,
    options: {
        responsive: !0,
        scales: {x: {display: !1}, y: {display: !1}},
        plugins: {title: {display: !1}, legend: {display: !1}},
        elements: {line: {tension: .5}}
    }
};
if (ctxExpences) {
    new Chart(ctxExpences, configExpences)
}
const ctxCash = document.getElementById("cashChart"), dataCash = {
    labels: labels,
    datasets: [{
        label: "Cash",
        data: Utils.numbers(NUMBER_CFG),
        borderColor: "#2775FF",
        backgroundColor: "#2775FF",
        pointRadius: 0
    }]
}, configCash = {
    type: "line",
    data: dataCash,
    options: {
        responsive: !0,
        scales: {x: {display: !1}, y: {display: !1}},
        plugins: {title: {display: !1}, legend: {display: !1}},
        elements: {line: {tension: .5}}
    }
};
if (ctxCash) {
    new Chart(ctxCash, configCash)
}
const ctxProfit = document.getElementById("profitChart"), dataProfit = {
    labels: labels,
    datasets: [{
        label: "Profit",
        data: Utils.numbers(NUMBER_CFG),
        borderColor: "#EC8C56",
        backgroundColor: "#EC8C56",
        pointRadius: 0
    }]
}, configProfit = {
    type: "line",
    data: dataProfit,
    options: {
        responsive: !0,
        scales: {x: {display: !1}, y: {display: !1}},
        plugins: {title: {display: !1}, legend: {display: !1}},
        elements: {line: {tension: .5}}
    }
};
if (ctxProfit) {
    new Chart(ctxProfit, configProfit)
}
const ctxEmployee = document.getElementById("employeeChart"), configEmployee = {
    type: "doughnut",
    data: {
        labels: ["Men", "Women"],
        datasets: [{
            label: "# of Votes",
            data: [70, 30],
            backgroundColor: ["#50D1B2", "#E23738"],
            borderWidth: 0,
            offset: 20
        }]
    },
    options: {
        rotation: -90,
        circumference: 180,
        legend: {display: !1},
        tooltip: {enabled: !1},
        cutout: 50,
        plugins: {
            legend: {
                display: !1,
                position: "bottom",
                align: "center",
                labels: {boxWidth: 8, boxHeight: 8, usePointStyle: !0, pointStyle: "circle", padding: 10}
            }
        }
    }
};
if (ctxEmployee) {
    new Chart(ctxEmployee, configEmployee)
}
const listGridBtn = document.querySelectorAll(".list-grid-btn");
for (let e = 0; e < listGridBtn.length; e++) listGridBtn[e].addEventListener("click", (function () {
    const e = document.getElementsByClassName("active");
    e[0].className = e[0].className.replace(" active", ""), this.className += " active", localStorage.setItem("activeClass", "true")
}));

function makeSidebarActive(e) {
    e.siblings().each((function () {
        $(this).removeClass("active")
    })), e.addClass("active")
}

$(document).ready((function () {
    if (localStorage) {
        var e = localStorage.sideMenuItem;
        makeSidebarActive($(".sidemenu-item").eq(e))
    }
    $(".sidemenu-item").click((function () {
        localStorage && (localStorage.sideMenuItem = $(this).index()), makeSidebarActive($(this))
    }))
}));

// const detailButtons = document.querySelectorAll(".show-detail"), detailModal = document.getElementById("details-modal"),
//     sidebarTransaction = document.getElementById("transaction-detail");
// sidebarTransaction.addEventListener("click", (() => {
//     detailModal.checked = !0
// })), detailButtons.forEach((e => {
//     e.addEventListener("click", (() => {
//         detailModal.checked = !0
//     }))
// }));

$('.password-toggle').on('click', function () {
    const element = $(this);
    const id = element.data('id');
    const image = element.find('img');
    const onSrc = image.attr('on-src');
    const offSrc = image.attr('off-src');

    if (element.data("show") === "1") {
        element.data("show", "0");
        $(`#${id}`).attr("type", "password");
        image.attr("src", offSrc);
    } else {
        element.data("show", "1");
        $(`#${id}`).attr("type", "text");
        image.attr("src", onSrc);
    }

})


//# sourceMappingURL=app.js.map
