const calcMaxPage = (elementAmount, pageSize) =>
    Math.floor(elementAmount / pageSize) + 1;

const toTimeFormat = (time) => {
    if (!time)
        return;
    time = time.replace('T', ' ');
    time = time.slice(0, time.length - 5)
    return time
};

module.exports = { calcMaxPage, toTimeFormat };