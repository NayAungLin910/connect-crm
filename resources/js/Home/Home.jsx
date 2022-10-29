import React, { useState, useEffect } from "react";
import { baseUrl, cusaxios, showToast } from "../config";
import BarChartReactJS from "../BarChartReactJs/BarChartReactJS";
import PieChartReactJs from "../PieChartReactJs/PieChartReactJs";
import Spinner from "../Spinner/Spinner";
import VerticalBarChartReactJs from "../VerticalBarChartReactJs/VerticalBarChartReactJs";

const Home = () => {
    let currentYear = new Date().getFullYear();
    let yearRange = [];
    for (currentYear; currentYear >= 2000; currentYear--) {
        yearRange.push(currentYear);
    }

    // yearly lead bar chart
    const [yearYearLeadBar, setYearLeadBar] = useState(
        new Date().getFullYear()
    );
    const [lablesYearLeadBar, setLabelsYearLeadBar] = useState([]);
    const [datasetsYearLeadBar, setDataSetsYearLeadBar] = useState([]);
    const [loadingYearLeadBar, setLoadingYearLeadBar] = useState(true);

    const yearlyLeadBarlabel =
        "Yearly Bar Chart of the Leads of " + yearYearLeadBar;

    const getYearLeadBarData = () => {
        cusaxios
            .get(`/yearbar-data?year_year_bar=${yearYearLeadBar}`)
            .then((res) => {
                setLoadingYearLeadBar(false);
                let res_data = res.data;
                let { success, data } = res_data;
                if (success) {
                    setLabelsYearLeadBar(data.labels);
                    setDataSetsYearLeadBar(data.datasets);
                }
            });
    };

    // lead pie chart percentage
    const [labelsLeadPie, setLabelsLeadPie] = useState([]);
    const [datasetsLeadPie, setDataSetsLeadPie] = useState([]);
    const [loadingLeadPie, setLoadingLeadPie] = useState(true);

    const getLeadPieData = () => {
        cusaxios
            .get(`/lead-pie-data?year_year_bar=${yearYearLeadBar}`)
            .then((res) => {
                setLoadingLeadPie(false);
                let res_data = res.data;
                let { success, data } = res_data;
                if (success) {
                    setLabelsLeadPie(data.labels);
                    setDataSetsLeadPie(data.datasets);
                }
            });
    };

    // total revenue yearly
    const [yearRevenueLead, setYearRevenueLead] = useState(
        new Date().getFullYear()
    );
    const [labelsRevenueLead, setLabelsRevenueLead] = useState([]);
    const [datasetsRevenueLead, setDatasetsRevenueLead] = useState([]);
    const [lodingRevenueLead, setLoadingRevenueLead] = useState(true);
    const labelRevenueLead = `Total Mothly Revenue of ${yearRevenueLead}!`;

    const getRevenueLeadData = () => {
        cusaxios
            .get(`/revenue-lead-data?year_revenue_lead=${yearRevenueLead}`)
            .then((res) => {
                setLoadingRevenueLead(false);
                let res_data = res.data;
                let { success, data } = res_data;
                if (success) {
                    setLabelsRevenueLead(data.labels);
                    setDatasetsRevenueLead(data.datasets);
                }
            });
    };

    // top lead vertical barchart
    const months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    const [yearTopLead, setYearTopLead] = useState(new Date().getFullYear());
    const [monthTopLead, setMonthTopLead] = useState(new Date().getMonth() + 1);
    const [numberTopLead, setNumberTopLead] = useState(10);
    const [labelsTopLead, setLabelsTopLead] = useState([]);
    const [datasetsTopLead, setDatasetsTopLead] = useState([]);
    const [loadingTopLead, setLoadingTopLead] = useState(true);

    // function for getting month name of the given month in number
    const getMonthName = (monthNumber) => {
        const date = new Date();
        date.setMonth(monthNumber - 1);

        return date.toLocaleString("en-US", { month: "long" });
    };

    const labelTopLead = `Top ${numberTopLead} leads of ${getMonthName(
        monthTopLead
    )}, ${yearTopLead}`;

    // get the top lead data for vertical bar chart
    const getTopLeadData = () => {
        cusaxios
            .get(
                `/top-lead-data?year_top_lead=${yearTopLead}&month_top_lead=${monthTopLead}&number_top_lead=${numberTopLead}`
            )
            .then((res) => {
                setLoadingTopLead(false);
                let res_data = res.data;
                let { success, data } = res_data;
                if (success) {
                    setLabelsTopLead(data.labels);
                    setDatasetsTopLead(data.datasets);
                } else {
                    showToast(
                        "The request for the top lead data failed!",
                        "error"
                    );
                }
            })
            .catch(function (error) {
                setLoadingTopLead(false);
                showToast("The request for the top lead data failed!", "error");
            });
    };

    // useEffect for lead yearly bar chart and lead pie chart
    useEffect(() => {
        getYearLeadBarData();
        getLeadPieData();
    }, [yearYearLeadBar]);

    // useEffect for revenue lead year bar chart
    useEffect(() => {
        getRevenueLeadData();
    }, [yearRevenueLead]);

    // useEffect for getting top lead vertical bar chart data
    useEffect(() => {
        getTopLeadData();
    }, [yearTopLead, monthTopLead, numberTopLead]);

    return (
        <>
            <div className="row mt-4">
                <h3 className="text-center mb-3">
                    <i className="bi bi-speedometer2 mx-2"></i>Dasboard
                </h3>
            </div>
            <div className="row my-2">
                <div className="col-sm-3">
                    <label htmlFor="select-year-lead-yearly-bar">
                        Select Year of the Bar Chart:{" "}
                    </label>
                    <select
                        value={yearYearLeadBar}
                        id="select-year-lead-yearly-bar"
                        className="form-select"
                        aria-label="Default select example"
                        onChange={(e) => {
                            setYearLeadBar(e.target.value);
                        }}
                    >
                        {yearRange.map((year) => (
                            <option key={year} value={year}>
                                {year}
                            </option>
                        ))}
                    </select>
                </div>
            </div>
            <div className="row">
                <div className="col-sm-7">
                    {loadingYearLeadBar ? (
                        <div className="mt-5">
                            <Spinner />
                        </div>
                    ) : (
                        <BarChartReactJS
                            label={yearlyLeadBarlabel}
                            labels={lablesYearLeadBar}
                            datasets={datasetsYearLeadBar}
                        />
                    )}
                </div>
                <div className="col-sm-4">
                    {loadingLeadPie ? (
                        <div className="mt-5">
                            <Spinner />
                        </div>
                    ) : (
                        <PieChartReactJs
                            label={datasetsLeadPie[0].label}
                            labels={labelsLeadPie}
                            datasets={datasetsLeadPie}
                        />
                    )}
                </div>
            </div>
            <div className="row mt-5 mb-4">
                <div className="col-sm-3">
                    <label htmlFor="select-year-lead-top-bar">
                        Select Year:{" "}
                    </label>
                    <select
                        value={yearTopLead}
                        id="select-year-lead-top-bar"
                        className="form-select"
                        aria-label="Select for year of top lead bar"
                        onChange={(e) => {
                            setYearTopLead(e.target.value);
                        }}
                    >
                        {yearRange.map((year) => (
                            <option key={year} value={year}>
                                {year}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="col-sm-3">
                    <label htmlFor="select-month-lead-top-bar">
                        Select Month:{" "}
                    </label>
                    <select
                        value={monthTopLead}
                        id="select-month-lead-top-bar"
                        className="form-select"
                        aria-label="Select for year of top lead bar"
                        onChange={(e) => {
                            setMonthTopLead(e.target.value);
                        }}
                    >
                        {months.map((month) => (
                            <option key={month} value={month}>
                                {getMonthName(month)}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="col-sm-3">
                    <label htmlFor="select-number-lead-top-bar">
                        Select Total Number of Leads:{" "}
                    </label>
                    <select
                        value={numberTopLead}
                        id="select-number-lead-top-bar"
                        className="form-select"
                        aria-label="Select for total number of leads for top lead bar"
                        onChange={(e) => {
                            setNumberTopLead(e.target.value);
                        }}
                    >
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div className="col-sm-12">
                    {loadingTopLead ? (
                        <div className="mt-5">
                            <Spinner />
                        </div>
                    ) : (
                        <VerticalBarChartReactJs
                            label={labelTopLead}
                            labels={labelsTopLead}
                            datasets={datasetsTopLead}
                        />
                    )}
                </div>
                <div className="col-sm-3">
                    <label htmlFor="select-revenue-lead">Select Year: </label>
                    <select
                        className="form-select"
                        value={yearRevenueLead}
                        onChange={(e) => {
                            setYearRevenueLead(e.target.value);
                        }}
                        id="select-revenue-lead"
                    >
                        {yearRange.map((year) => (
                            <option key={year} value={year}>
                                {year}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="col-sm-12">
                    {lodingRevenueLead ? (
                        <div className="mt-5">
                            <Spinner />
                        </div>
                    ) : (
                        <BarChartReactJS
                            label={labelRevenueLead}
                            labels={labelsRevenueLead}
                            datasets={datasetsRevenueLead}
                        />
                    )}
                </div>
            </div>
        </>
    );
};

export default Home;
