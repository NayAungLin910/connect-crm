import React, { useRef, useCallback, createElement } from "react";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";
import { Bar } from "react-chartjs-2";

const BarChartReactJS = ({ label, labels, datasets }) => {
    let barChartRef = useRef();

    const downloadImage = useCallback(() => {
        const link = document.createElement("a");
        link.download = `${label}.png`;
        link.href = barChartRef.current.toBase64Image();
        link.click();
    }, [label]);

    ChartJS.register(
        CategoryScale,
        LinearScale,
        BarElement,
        Title,
        Tooltip,
        Legend
    );

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
            <button className="btn btn-sm btn-primary" onClick={downloadImage}>
                <i className="bi bi-download"></i>
            </button>
            <Bar ref={barChartRef} options={options} data={data} />
        </div>
    );
};

export default BarChartReactJS;
