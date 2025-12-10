@extends('templates.app')

@section('content')
<style>
    .dashboard-container {
        max-width: 1400px;
        margin: 2rem auto;
        padding: 0 20px;
    }

    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
        position: relative;
        overflow: hidden;
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #2d3748, #4a5568);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-label {
        color: #718096;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .trend-up {
        color: #38a169;
    }

    .trend-down {
        color: #e53e3e;
    }

    .quick-actions {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2.5rem;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .section-title {
        color: #2d3748;
        font-weight: 700;
        margin-bottom: 2rem;
        font-size: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 2px;
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f7fafc, #edf2f7);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        text-decoration: none;
        color: #2d3748;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        transition: left 0.3s ease;
        z-index: 1;
    }

    .action-btn:hover::before {
        left: 0;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
        color: white;
    }

    .action-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        background: white;
        color: #667eea;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .action-btn:hover .action-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }

    .action-content {
        position: relative;
        z-index: 2;
    }

    .action-title {
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .action-desc {
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .recent-activity {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .activity-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 1.25rem 0;
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s ease;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item:hover {
        background: #f7fafc;
        margin: 0 -1rem;
        padding: 1.25rem 1rem;
        border-radius: 8px;
    }

    .activity-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.25rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        margin: 0;
        color: #2d3748;
        font-weight: 500;
    }

    .activity-time {
        font-size: 0.875rem;
        color: #718096;
        margin: 0.25rem 0 0 0;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .action-grid {
            grid-template-columns: 1fr;
        }

        .welcome-card {
            padding: 2rem 1.5rem;
        }

        .welcome-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Welcome Card -->
     <div class="container mt-5">
        <h5>Dashboard Admin</h5>
        @if (Session::get('success'))
            <div class="alert alert-success">Selamat Datang, <b>{{Auth::user()->name}}</b></div>
        @endif
    </div>
</div>
@endsection
