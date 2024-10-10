async function sendPostRequest(endpoint, data) {
    const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    if (response.ok) {
        console.log('Success:', result);
    } else {
        console.error('Error:', result);
    }

    return result;
}

function handleCategoryClick(id, category) {
    const endpoint = '/api/v1/visitors/' + id;
    const data = {
        category: category,
    };

    sendPostRequest(endpoint, data);

    const btnEmployee = document.getElementById("btn-employee-" + id);
    const btnPress = document.getElementById("btn-press-" + id);
    const btnVip = document.getElementById("btn-vip-" + id);
    const btnGuest = document.getElementById("btn-guest-" + id);

    btnEmployee.className = "btn";
    btnPress.className = "btn";
    btnVip.className = "btn";
    btnGuest.className = "btn";

    if (category === 'Сотрудник') {
        btnEmployee.className = "btn btn-employee";
    } else if (category === 'СМИ') {
        btnPress.className = "btn btn-press";
    } else if (category === 'VIP') {
        btnVip.className = "btn btn-vip";
    } else if (category === 'Гость') {
        btnGuest.className = "btn btn-guest";
    }
}

function handleRejectionClick(id, isRejected) {
    const endpoint = '/api/v1/visitors/' + id;
    const data = {
        isRejected: isRejected,
    };

    sendPostRequest(endpoint, data);

    const elem = document.getElementById("btn-rejected-" + id);

    if (isRejected === 1) {
        elem.className = "btn btn-rejected";
    } else {
        elem.className = "btn";
    }

    elem.onclick = function() {
        handleRejectionClick(id, 1 - isRejected);
    };
}

window.handleCategoryClick = handleCategoryClick;
window.handleRejectionClick = handleRejectionClick;
