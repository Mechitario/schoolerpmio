'use client'

import React from 'react'
import {
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
  AreaChart,
  Area,
  Line,
  ComposedChart,
} from 'recharts'
import {
  Users,
  UserCog,
  TrendingDown,
  DollarSign,
  ArrowUpRight,
  ArrowDownRight,
  CheckCircle2,
  Clock,
  ChevronRight,
  Download,
  BarChart3,
  Wallet,
  Trophy,
  Calendar,
} from 'lucide-react'
import {
  DataTable,
  DataTableHeader,
  DataTableHeaderCell,
  DataTableBody,
  DataTableRow,
  DataTableCell,
  DataTableFooter,
} from '../../components/DataTable'

const REVENUE_DATA = [
  { month: 'Jan', income: 38200, expenses: 11800 },
  { month: 'Feb', income: 40100, expenses: 12200 },
  { month: 'Mar', income: 39500, expenses: 11900 },
  { month: 'Apr', income: 42800, expenses: 12500 },
  { month: 'May', income: 41200, expenses: 12100 },
  { month: 'Jun', income: 44500, expenses: 12800 },
  { month: 'Jul', income: 43800, expenses: 12600 },
  { month: 'Aug', income: 45200, expenses: 12700 },
  { month: 'Sep', income: 44100, expenses: 12400 },
  { month: 'Oct', income: 46800, expenses: 13100 },
  { month: 'Nov', income: 45900, expenses: 12900 },
  { month: 'Dec', income: 47200, expenses: 13200 },
]

const ENROLLMENT_DATA = [
  { month: 'Jan', students: 1180, target: 1250 },
  { month: 'Feb', students: 1195, target: 1250 },
  { month: 'Mar', students: 1210, target: 1250 },
  { month: 'Apr', students: 1222, target: 1250 },
  { month: 'May', students: 1235, target: 1250 },
  { month: 'Jun', students: 1240, target: 1250 },
  { month: 'Jul', students: 1242, target: 1250 },
  { month: 'Aug', students: 1245, target: 1250 },
  { month: 'Sep', students: 1246, target: 1250 },
  { month: 'Oct', students: 1247, target: 1250 },
  { month: 'Nov', students: 1248, target: 1250 },
  { month: 'Dec', students: 1248, target: 1250 },
]

const FEE_COLLECTIONS = [
  { id: '1', name: 'Aman Gupta', email: 'aman.g@school.com', class: '10-A', amount: 450, status: 'Paid' as const, time: '2h ago' },
  { id: '2', name: 'Sarah Khan', email: 'sarah.k@school.com', class: '12-B', amount: 1200, status: 'Paid' as const, time: '5h ago' },
  { id: '3', name: 'Rajesh Kumar', email: 'rajesh.k@school.com', class: '9-C', amount: 300, status: 'Pending' as const, time: '1d ago' },
  { id: '4', name: 'Lisa Ray', email: 'lisa.r@school.com', class: '11-A', amount: 600, status: 'Paid' as const, time: '2d ago' },
  { id: '5', name: 'Vikram Singh', email: 'vikram.s@school.com', class: '10-B', amount: 450, status: 'Paid' as const, time: '3d ago' },
]

const TOP_PERFORMERS = [
  { name: 'Arjun Verma', score: 98, rank: 1, image: 'https://ui-avatars.com/api/?name=Arjun+Verma&background=3b82f6&color=fff' },
  { name: 'Simran Kaur', score: 96, rank: 2, image: 'https://ui-avatars.com/api/?name=Simran+Kaur&background=6366f1&color=fff' },
  { name: 'Priya Singh', score: 94, rank: 3, image: 'https://ui-avatars.com/api/?name=Priya+Singh&background=059669&color=fff' },
  { name: 'Rahul Dev', score: 92, rank: 4, image: 'https://ui-avatars.com/api/?name=Rahul+Dev&background=d97706&color=fff' },
]

const CHART_COLORS = { income: '#3b82f6', expenses: '#dc2626', students: '#6366f1', target: '#d1d5db' }

export default function DashboardPage() {
  return (
    <div className="space-y-6">
      {/* Page title - Laravel style */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 className="text-2xl font-semibold text-gray-900">Dashboard</h1>
        <div className="flex gap-2">
          <button className="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50">
            <Download size={16} />
            Export
          </button>
          <button className="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded bg-blue-600 text-white hover:bg-blue-700">
            Generate Report
          </button>
        </div>
      </div>

      {/* Stats - Laravel style small cards */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div className="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
          <div className="flex items-center justify-between">
            <div className="p-2 rounded bg-blue-50 text-blue-600">
              <Users size={20} />
            </div>
            <span className="text-xs font-medium text-green-600 flex items-center gap-0.5">
              <ArrowUpRight size={14} /> +12%
            </span>
          </div>
          <p className="mt-3 text-2xl font-semibold text-gray-900">1,248</p>
          <p className="text-sm text-gray-500">Total Students</p>
        </div>
        <div className="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
          <div className="flex items-center justify-between">
            <div className="p-2 rounded bg-indigo-50 text-indigo-600">
              <UserCog size={20} />
            </div>
            <span className="text-xs font-medium text-green-600 flex items-center gap-0.5">
              <ArrowUpRight size={14} /> +2
            </span>
          </div>
          <p className="mt-3 text-2xl font-semibold text-gray-900">84</p>
          <p className="text-sm text-gray-500">Active Staff</p>
        </div>
        <div className="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
          <div className="flex items-center justify-between">
            <div className="p-2 rounded bg-green-50 text-green-600">
              <DollarSign size={20} />
            </div>
            <span className="text-xs font-medium text-green-600 flex items-center gap-0.5">
              <ArrowUpRight size={14} /> +5.4%
            </span>
          </div>
          <p className="mt-3 text-2xl font-semibold text-gray-900">$45,200</p>
          <p className="text-sm text-gray-500">Monthly Revenue</p>
        </div>
        <div className="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
          <div className="flex items-center justify-between">
            <div className="p-2 rounded bg-red-50 text-red-600">
              <TrendingDown size={20} />
            </div>
            <span className="text-xs font-medium text-red-600 flex items-center gap-0.5">
              <ArrowDownRight size={14} /> -2.1%
            </span>
          </div>
          <p className="mt-3 text-2xl font-semibold text-gray-900">$12,800</p>
          <p className="text-sm text-gray-500">Expenses</p>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Left: Charts */}
        <div className="lg:col-span-2 space-y-6">
          <div className="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div className="px-4 py-3 border-b border-gray-200 bg-gray-50">
              <h3 className="font-semibold text-gray-900">Revenue Analytics</h3>
              <p className="text-xs text-gray-500">Income vs expenses · Last 12 months</p>
            </div>
            <div className="p-4">
              <div className="h-[280px] w-full">
                <ResponsiveContainer width="100%" height="100%">
                  <ComposedChart data={REVENUE_DATA} margin={{ top: 8, right: 8, left: 0, bottom: 0 }}>
                    <CartesianGrid strokeDasharray="3 3" stroke="#e5e7eb" vertical={false} />
                    <XAxis dataKey="month" tick={{ fontSize: 11, fill: '#6b7280' }} axisLine={{ stroke: '#e5e7eb' }} tickLine={false} />
                    <YAxis tick={{ fontSize: 11, fill: '#6b7280' }} axisLine={false} tickLine={false} tickFormatter={(v) => `$${(v / 1000).toFixed(0)}k`} />
                    <Tooltip contentStyle={{ borderRadius: 4, border: '1px solid #e5e7eb', fontSize: 12 }} formatter={(value: number, name: string) => [`$${value.toLocaleString()}`, name]} />
                    <Legend wrapperStyle={{ paddingTop: 8 }} formatter={(value) => <span className="text-xs text-gray-600">{value}</span>} />
                    <Bar dataKey="income" name="Income" fill={CHART_COLORS.income} radius={[2, 2, 0, 0]} maxBarSize={32} />
                    <Bar dataKey="expenses" name="Expenses" fill={CHART_COLORS.expenses} radius={[2, 2, 0, 0]} maxBarSize={32} />
                  </ComposedChart>
                </ResponsiveContainer>
              </div>
            </div>
          </div>

          <div className="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div className="px-4 py-3 border-b border-gray-200 bg-gray-50">
              <h3 className="font-semibold text-gray-900">Enrollment Trend</h3>
              <p className="text-xs text-gray-500">Student count vs target</p>
            </div>
            <div className="p-4">
              <div className="h-[240px] w-full">
                <ResponsiveContainer width="100%" height="100%">
                  <AreaChart data={ENROLLMENT_DATA} margin={{ top: 8, right: 8, left: 0, bottom: 0 }}>
                    <defs>
                      <linearGradient id="colorStudents" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stopColor={CHART_COLORS.students} stopOpacity={0.3} />
                        <stop offset="100%" stopColor={CHART_COLORS.students} stopOpacity={0} />
                      </linearGradient>
                    </defs>
                    <CartesianGrid strokeDasharray="3 3" stroke="#e5e7eb" vertical={false} />
                    <XAxis dataKey="month" tick={{ fontSize: 11, fill: '#6b7280' }} axisLine={{ stroke: '#e5e7eb' }} tickLine={false} />
                    <YAxis tick={{ fontSize: 11, fill: '#6b7280' }} axisLine={false} tickLine={false} domain={[1100, 1300]} />
                    <Tooltip contentStyle={{ borderRadius: 4, border: '1px solid #e5e7eb', fontSize: 12 }} formatter={(value: number) => [value.toLocaleString(), '']} />
                    <Area type="monotone" dataKey="students" name="Students" stroke={CHART_COLORS.students} strokeWidth={2} fill="url(#colorStudents)" />
                    <Line type="monotone" dataKey="target" name="Target" stroke={CHART_COLORS.target} strokeWidth={2} strokeDasharray="5 5" dot={false} />
                  </AreaChart>
                </ResponsiveContainer>
              </div>
            </div>
          </div>
        </div>

        {/* Right: Sidebar */}
        <aside className="space-y-6">
          <div className="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div className="px-4 py-3 border-b border-gray-200 bg-gray-50">
              <h3 className="font-semibold text-gray-900">Top Performers</h3>
            </div>
            <div className="p-4 space-y-4">
              {TOP_PERFORMERS.map((p) => (
                <div key={p.rank} className="flex items-center gap-3">
                  <img src={p.image} alt={p.name} className="w-10 h-10 rounded-full object-cover" />
                  <div className="flex-1 min-w-0">
                    <p className="text-sm font-medium text-gray-900 truncate">{p.name}</p>
                    <div className="flex items-center gap-2 mt-0.5">
                      <div className="flex-1 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div className="h-full bg-blue-500 rounded-full" style={{ width: `${p.score}%` }} />
                      </div>
                      <span className="text-xs text-gray-500 w-7">{p.score}%</span>
                    </div>
                  </div>
                </div>
              ))}
            </div>
            <div className="px-4 pb-4">
              <button className="w-full py-2 text-sm font-medium border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50">
                View full rankings
              </button>
            </div>
          </div>

          <div className="bg-gray-800 text-white rounded-lg overflow-hidden border border-gray-700">
            <div className="p-4">
              <div className="flex items-center gap-2 mb-3">
                <Calendar size={18} className="text-gray-400" />
                <h3 className="font-semibold">Upcoming Events</h3>
              </div>
              <p className="text-sm text-gray-300 mb-4">
                Annual sports meet — <strong>March 15th</strong>. Prep meeting today at 4:00 PM.
              </p>
              <button className="w-full py-2 text-sm font-medium rounded bg-blue-600 hover:bg-blue-700 flex items-center justify-center gap-1">
                Set Reminder <ChevronRight size={14} />
              </button>
            </div>
          </div>

          <div className="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div className="px-4 py-3 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
              <h3 className="font-semibold text-gray-900">Teacher of the Month</h3>
              <span className="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded">New</span>
            </div>
            <div className="p-4">
              <p className="text-sm text-gray-600 mb-4">Congratulations to Mrs. Sharma for outstanding performance!</p>
              <div className="flex -space-x-2">
                {[1, 2, 3, 4].map((i) => (
                  <img key={i} src={`https://ui-avatars.com/api/?name=Staff+${i}`} alt="" className="w-8 h-8 rounded-full border-2 border-white object-cover" />
                ))}
                <div className="w-8 h-8 rounded-full border-2 border-white bg-gray-200 flex items-center justify-center text-xs font-medium text-gray-600">+12</div>
              </div>
            </div>
          </div>
        </aside>
      </div>

      {/* Recent Fee Collections - Laravel style card + table */}
      <div className="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div className="px-4 py-3 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
          <div>
            <h3 className="font-semibold text-gray-900">Recent Fee Collections</h3>
            <p className="text-xs text-gray-500">Latest transactions</p>
          </div>
          <button className="text-sm font-medium text-blue-600 hover:text-blue-700 flex items-center gap-1">
            View all <ChevronRight size={14} />
          </button>
        </div>
        <DataTable
          striped
          footer={
            <DataTableFooter>
              <p className="text-sm text-gray-500">Showing last 5 transactions</p>
              <button className="text-sm font-medium text-blue-600 hover:underline">View full history</button>
            </DataTableFooter>
          }
        >
          <DataTableHeader>
            <DataTableHeaderCell>Student</DataTableHeaderCell>
            <DataTableHeaderCell>Class</DataTableHeaderCell>
            <DataTableHeaderCell align="right">Amount</DataTableHeaderCell>
            <DataTableHeaderCell align="center">Status</DataTableHeaderCell>
          </DataTableHeader>
          <DataTableBody>
            {FEE_COLLECTIONS.map((row) => (
              <DataTableRow key={row.id}>
                <DataTableCell>
                  <div className="flex items-center gap-3">
                    <img
                      src={`https://ui-avatars.com/api/?name=${encodeURIComponent(row.name)}&size=80&background=3b82f6&color=fff`}
                      alt=""
                      className="w-8 h-8 rounded object-cover"
                    />
                    <div>
                      <p className="font-medium text-gray-900">{row.name}</p>
                      <p className="text-xs text-gray-500">{row.email}</p>
                    </div>
                  </div>
                </DataTableCell>
                <DataTableCell>
                  <span className="text-sm text-gray-700">{row.class}</span>
                </DataTableCell>
                <DataTableCell align="right">
                  <span className="font-medium text-gray-900">${row.amount.toLocaleString()}</span>
                  <span className="block text-xs text-gray-500">{row.time}</span>
                </DataTableCell>
                <DataTableCell align="center">
                  <span
                    className={
                      'inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium ' +
                      (row.status === 'Paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')
                    }
                  >
                    {row.status}
                  </span>
                </DataTableCell>
              </DataTableRow>
            ))}
          </DataTableBody>
        </DataTable>
      </div>
    </div>
  )
}
