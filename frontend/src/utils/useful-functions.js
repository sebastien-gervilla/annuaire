const calcMaxPage = (elementAmount, pageSize) =>
    Math.floor(elementAmount / pageSize) + 1;

module.exports = { calcMaxPage };