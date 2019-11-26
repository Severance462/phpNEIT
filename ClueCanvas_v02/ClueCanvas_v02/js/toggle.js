function toggleClass(element, classA, classB) {
    if (element.classList.contains(classA)) {
        element.classList.add(classB);
        element.classList.remove(classA);
    } else {
        element.classList.add(classA);
        element.classList.remove(classB);
    }
}

function toggleClasses(elementA, elementB, classA, classB) {
    toggleClass(elementA, classA, classB);
    toggleClass(elementB, classB, classA);
}

function toggleDisplay(elementA, elementB) {
    toggleClass(elementA, 'hideItem', 'showItem');
    toggleClass(elementB, 'showItem', 'hideItem');
}

function toggleDisplayById(idA, idB) {
    var elementA = document.getElementById(idA);
    var elementB = document.getElementById(idB);
    toggleClass(elementA, 'hideItem', 'showItem');
    toggleClass(elementB, 'showItem', 'hideItem');
}