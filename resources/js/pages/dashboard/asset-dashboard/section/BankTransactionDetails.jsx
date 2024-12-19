import React from "react";

const BankTransactionDetails = () => {
    return (
        <div className="col-md-5 col-sm-12">
            <div>
                <div className="card">
                    <div className="card-body">
                        <h6 className="text-lg mb-3">
                            {" "}
                            Bank Transaction Details
                        </h6>
                        <hr></hr>
                        <div className="mt-16">
                            <div className="d-flex align-items-center justify-content-between gap-3 mb-24">
                                <div className="d-flex align-items-center">
                                    <div className="flex-grow-1">
                                        <h6 className="text-md mb-0 fw-medium">
                                            UCB
                                        </h6>
                                        <span className="text-sm text-secondary-light fw-medium">
                                            June 19 2023 at 16.42
                                        </span>
                                    </div>
                                </div>
                                <span className="text-primary-light text-md fw-medium">
                                    28,000.00 tk
                                </span>
                            </div>
                            <div className="d-flex align-items-center justify-content-between gap-3 mb-24">
                                <div className="d-flex align-items-center">
                                    <img
                                        src="assets/images/users/user2.png"
                                        alt=""
                                        className="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden"
                                    />
                                    <div className="flex-grow-1">
                                        <h6 className="text-md mb-0 fw-medium">
                                            Wade Warren
                                        </h6>
                                        <span className="text-sm text-secondary-light fw-medium">
                                            Agent ID: 36254
                                        </span>
                                    </div>
                                </div>
                                <span className="text-primary-light text-md fw-medium">
                                    $20
                                </span>
                            </div>
                            <div className="d-flex align-items-center justify-content-between gap-3 mb-24">
                                <div className="d-flex align-items-center">
                                    <img
                                        src="assets/images/users/user3.png"
                                        alt=""
                                        className="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden"
                                    />
                                    <div className="flex-grow-1">
                                        <h6 className="text-md mb-0 fw-medium">
                                            Albert Flores
                                        </h6>
                                        <span className="text-sm text-secondary-light fw-medium">
                                            Agent ID: 36254
                                        </span>
                                    </div>
                                </div>
                                <span className="text-primary-light text-md fw-medium">
                                    $30
                                </span>
                            </div>
                            <div className="d-flex align-items-center justify-content-between gap-3 mb-24">
                                <div className="d-flex align-items-center">
                                    <img
                                        src="assets/images/users/user4.png"
                                        alt=""
                                        className="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden"
                                    />
                                    <div className="flex-grow-1">
                                        <h6 className="text-md mb-0 fw-medium">
                                            UCB
                                        </h6>
                                        <span className="text-sm text-secondary-light fw-medium">
                                            Agent ID: 36254
                                        </span>
                                    </div>
                                </div>
                                <span className="text-primary-light text-md fw-medium">
                                    $40
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default BankTransactionDetails;
