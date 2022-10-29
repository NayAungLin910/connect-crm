import React, { useRef, useCallback } from "react";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Pie } from "react-chartjs-2";

const PieChartReactJs = ({ label, labels, datasets }) => {
    let pieChartRef = useRef();

    const downloadImage = useCallback(() => {
        const link = document.createElement("a");
        link.download = `${label}.png`;
        link.href = pieChartRef.current.toBase64Image();
        link.click();
    }, [label]);

    ChartJS.register(ArcElement, Tooltip, Legend);

    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: "top",
            },
            title: {
                display: true,
                text: label,
                font: {
                    size: 17,
                },
            },
        },
    };

    const data = {
        labels,
        datasets,
    };
    return (
        <div className="my-3">
            <button onClick={downloadImage} className="btn btn-sm btn-primary">
                <i className="bi bi-download"></i>
            </button>
            <Pie ref={pieChartRef} data={data} options={options} />
        </div>
    );
};

export default PieChartReactJs;
