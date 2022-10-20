const toTimeFormat = (time) => {
    if (!time)
        return 'Indéterminé';

    time = time.slice(0, time.length - 3)
    time = time.replace(':', 'h')
    return time
};

module.exports = { toTimeFormat };