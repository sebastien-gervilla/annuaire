const calcMaxPage = (elementAmount, pageSize) =>
    Math.floor(elementAmount / pageSize) + 1;

const toTimeFormat = (time) => {
    if (!time)
        return 'Indéterminé';

    time = time.slice(0, time.length - 3)
    time = time.replace(':', 'h')
    return time
};

module.exports = { calcMaxPage, toTimeFormat };