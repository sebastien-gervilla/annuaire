import { useState } from "react";

export default function usePagination(pageSize = 6) {
    const [pagination, setPagination] = useState({
        page: 0,
        pageSize: pageSize,
        maxPage: 0
    });

    const updateMax = (length) => setPagination({
        ...pagination,
        maxPage: Math.floor(length / (pagination.pageSize + 1)) + 1
    })

    const nextPage = () => changePage(1);

    const prevPage = () => changePage(-1);

    const refreshPage = (length) =>
        (length % pagination.pageSize === 0 && length / pagination.pageSize !== 0) &&
            setPagination({...pagination, page: length / 6 - 1});

    const changePage = value => {
        let newPage = pagination.page + value;
        const pages = pagination.maxPage - 1;
        newPage = newPage > pages ? pages :
            newPage <= 0 ? 0 : newPage;
        setPagination({...pagination, page: newPage});
    };

    return { page: pagination.page, maxPage: pagination.maxPage, updateMax, nextPage, prevPage, refreshPage };
}